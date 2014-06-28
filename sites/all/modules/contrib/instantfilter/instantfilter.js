(function ($) {

/**
 * Attaches the Instant filter behavior.
 */
Drupal.behaviors.instantFilter = {
  attach: function (context, settings) {
    // Bind instantfilter behaviors specified in the settings.
    for (var base in settings.instantfilter) {
      $('#' + base + ':input', context).once('instantfilter', function () {
        var $this = $(this);
        $this.data('instantfilter', new Drupal.instantFilter(this, settings.instantfilter[base]));
        $this.trigger('drupalInstantFilterCreated');
      });
    }

    // Bind instantfilter behaviors to all elements showing the class.
    $('.instantfilter-filter:input', context).once('instantfilter', function () {
      var $this = $(this);
      $this.data('instantfilter', new Drupal.instantFilter(this));
      $this.trigger('drupalInstantFilterCreated');
    });

    // If context has an parent with the instantfilter class, then context is
    // added dynamicly (e.g. using AJAX). If so, the index needs to be rebuild.
    $(context).closest('.instantfilter-container').each(function () {
      $(this).trigger('drupalInstantFilterIndexInvalidated');
    });
  }
};

/**
 * The Instant filter object.
 * 
 * @constructor
 * @param element
 *   DOM input element to attach the Instant filter to.
 * @param settings
 *   Settings for the Instant filter.
 */
Drupal.instantFilter = function (element, settings) {
  var self = this;
  this.instanceID = Drupal.instantFilter.instanceCounter++;

  this.settings = $.extend({
    container: null,
    groups: {
      '.instantfilter-group': { zebra: false }
    },
    items: {
      '.instantfilter-item': { ignore: null, allow: null, includeNext: null }
    },
    empty: Drupal.t('There were no results.')
  }, settings);
  this.index = false;

  this.element = $(element);
  if (this.settings.container) {
    this.container = $(this.settings.container);
  }
  else {
    this.container = $(document.body);
  }

  var events = (this.element.is('[type=text]')) ? 'keyup' : 'change';
  events += ' drupalInstantFilterTriggerSearch';
  this.element.bind(events, function () {
    self.applyFilter($.trim($(this).val().toLowerCase()));
    self.element.trigger('drupalInstantFilterAfterSearch');
  });

  this.container
    .addClass('instantfilter-container')
    .bind('drupalInstantFilterIndexInvalidated', function () {
      self.index = false;
    });

  // Rebuild Instant filter index on $(window).load().
  $(window).load(function () {
    if (!self.index) {
      self.rebuildIndex();
      self.index = true;
    }
  });

  // Apply filter once if the element is not empty.
  if (this.element.val()) {
    this.element.trigger('drupalInstantFilterTriggerSearch');
  }
};

/**
 * Instant filter hooks and instance counter.
 */
Drupal.instantFilter.hooks = Drupal.instantFilter.hooks || {};
Drupal.instantFilter.hooks.lengths = Drupal.instantFilter.hooks.lengths || {};
Drupal.instantFilter.hooks.alterItem = Drupal.instantFilter.hooks.alterItem || {};
Drupal.instantFilter.hooks.alterIndex = Drupal.instantFilter.hooks.alterIndex || {};
Drupal.instantFilter.hooks.alterMatch = Drupal.instantFilter.hooks.alterMatch || {};
Drupal.instantFilter.hooks.alterFilter = Drupal.instantFilter.hooks.alterFilter || {};
Drupal.instantFilter.instanceCounter = 0;

/**
 * Sort an object by its weight.
 */
Drupal.instantFilter.prototype.sortByWeight = function (object) {
  var tempArray = [];
  var tempArrayLength = 0;
  var tempObject = {};

  $.each(object, function (index, value) {
    value.weight = (typeof value.weight !== 'undefined') ? value.weight : 0;
    value.index = index;
    tempArray[tempArrayLength] = value;
    tempArrayLength++;
  });

  tempArray = tempArray.sort(function (a, b) {
    return a.weight - b.weight;
  });

  for (var i = 0; i < tempArrayLength; i++) {
    tempObject[tempArray[i].index] = tempArray[i];
  }

  return { hook: tempObject, length: tempArrayLength };
};

/**
 * Get text value of an item.
 */
Drupal.instantFilter.prototype.getValue = function (element, selector, passThrough) {
  var self = this;
  var settings = this.settings.items[selector];
  var $element = $(element);
  var text = '';

  if (typeof passThrough === 'undefined') {
    var passThrough = false;
  }

  if (settings.allow && !passThrough) {
    // Find whitelisted ('allowed') elements in the current item.
    $element.find(settings.allow).each(function () {
      // @todo replace parentsUntill selector with $element (jQuery 1.6.x).
      if (settings.ignore && $(this).parentsUntil(selector, settings.ignore).length) {
        // Ignore this element if at least one if its parents (up untill
        // $element) should be ignored.
        return;
      }
      text += self.getValue(this, selector, true);
    });

    return text.toLowerCase();
  }

  if (!settings.ignore || !$element.is(settings.ignore)) {
    for (var i = 0, len = element.childNodes.length; i < len; i++) {
      if (element.childNodes[i].nodeType == 1) { // ELEMENT_NODE
        text += this.getValue(element.childNodes[i], selector, passThrough);
      }
      else if (element.childNodes[i].nodeType == 3) { // TEXT_NODE
        text += element.childNodes[i].nodeValue;
      }
    }
  }

  return text.toLowerCase();
};

/**
 * Rebuild index of the filter.
 */
Drupal.instantFilter.prototype.rebuildIndex = function () {
  var self = this;
  var hooks = Drupal.instantFilter.hooks;
  var allitems = '';

  this.items = [];
  this.groups = [];

  this.noResults = this.element.closest('.form-item').siblings('.instantfilter-no-results');
  this.noResultsMessage = this.noResults.find('p').length;

  // Sort hooks by weight.
  $.each(hooks, function (hookId) {
    if (hookId !== 'lengths') {
      var sorted = self.sortByWeight(this);
      hooks[hookId] = sorted.hook;
      hooks.lengths[hookId] = sorted.length;
    }
  });

  var i = 0;
  for (var selector in this.settings.items) {
    allitems += ',' + selector;

    this.container.find(selector).each(function () {
      // Find the element next to the current element.
      if (typeof self.settings.items[selector].includeNext !== 'undefined') {
        var include = $(this).next(self.settings.items[selector].includeNext)[0];
      }

      // Undefined if includeNext is not set, or if .next(includeNext) filter
      // did not match the sibling next to the current item.
      if (typeof include === 'undefined') {
        var el = $(this);
        var val = self.getValue(this, selector);
      }
      else {
        var el = $([this, include]);
        var val = self.getValue(this, selector);
        val += self.getValue(include, selector);
      }

      var item = $.extend({}, self.settings.items[selector], {
        element: el,
        value: val,
        groupsLength: 0,
        groups: []
      });

      // Invoke item hooks.
      if (hooks.lengths.alterItem) {
        $.each(hooks.alterItem, function () {
          this.alter(self, item, i);
        });
      }

      self.items[i] = item;
      item.element.data('instantfilter:' + self.instanceID + ':item', i);
      i++;
    });
  }

  this.itemsLength = i;
  allitems = allitems.substring(1);

  var i = 0;
  for (var selector in this.settings.groups) {
    this.container.find(selector).each(function () {
      // Find the element previous to the current element.
      if (typeof self.settings.groups[selector].title !== 'undefined') {
        var title = $(this).prev(self.settings.groups[selector].title)[0];
      }

      // Undefined if title is not set, or if .prev(title) filter did not match
      // the sibling previous to the current item.
      var el = (typeof title === 'undefined') ? $(this) : $([this, title]);

      var group = $.extend({}, self.settings.groups[selector], {
        element: el,
        total: 0,
        results: 0
      });

      // Link group to items.
      group.children = group.element.find(group.items || allitems);
      group.children.each(function () {
        group.total++;

        var item = $(this).data('instantfilter:' + self.instanceID + ':item');
        if (item !== undefined && self.items[item]) {
          item = self.items[item];
          item.groups[item.groupsLength] = group;
          item.groupsLength++;
        }
      });

      self.groups[i] = group;
      group.element.data('instantfilter:' + self.instanceID + ':group', i);
      i++;
    });
  }

  this.groupsLength = i;

  // Invoke index hooks.
  if (hooks.lengths.alterIndex) {
    $.each(hooks.alterIndex, function () {
      this.alter(self);
    });
  }
};

/**
 * Filters all items for the given string.
 * 
 * All items containing the string will stay visible, while other items are
 * hidden. All groups that don't have any matching items will also be hidden.
 * 
 * @param search
 *   The string to filter items on.
 */
Drupal.instantFilter.prototype.applyFilter = function (search) {
  var self = this;
  var hooks = Drupal.instantFilter.hooks;

  if (!this.index) {
    this.rebuildIndex();
    this.index = true;
  }

  this.search = search;
  // Reset the total and group result counters.
  this.results = 0;
  for (var i = 0; i < this.groupsLength; i++) {
    this.groups[i].results = 0;
  }

  for (var i = 0; i < this.itemsLength; i++) {
    var item = this.items[i];
    var match = item.value.indexOf(this.search) >= 0;

    // Invoke match hooks.
    if (match && hooks.lengths.alterMatch) {
      $.each(hooks.alterMatch, function () {
        match = this.rule(self, item, i);
        if (!match) {
          // Break out of the loop if the match is false.
          return false;
        }
      });
    }

    if (match) {
      // Increment the total and item's groups result counters.
      this.results++;
      for (var j = 0; j < item.groupsLength; j++) {
        item.groups[j].results++;
      }
    }

    item.element.toggleClass('instantfilter-item-no-match', !match);
  }

  for (var i = 0; i < this.groupsLength; i++) {
    var group = this.groups[i];

    group.element.toggleClass('instantfilter-group-no-match', !group.results);

    if (group.zebra) {
      group.children.filter(':visible')
        .removeClass('odd even')
        .filter(':odd').addClass('even').end()
        .filter(':even').addClass('odd');
    }
  }

  // Invoke filter hooks.
  if (hooks.lengths.alterFilter) {
    $.each(hooks.alterFilter, function () {
      this.alter(self);
    });
  }

  // If any results are found, remove the 'no results' message.
  // Otherwise display the 'no results' message.
  if (this.results && this.noResultsMessage) {
    this.noResults.empty();
    this.noResultsMessage = false;
  }
  else if (!this.results && !this.noResultsMessage) {
    this.noResults.append($('<p />').text(this.settings.empty));
    this.noResultsMessage = true;
  }
};

})(jQuery);
