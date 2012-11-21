<div id="skipnav" class="element-invisible">
  <div class="container">
    <p>Skip to:</p>
    <ul>
      <li><a href="#content" class="element-invisible element-focusable"><?php print t('Skip to content'); ?></a></li>
      <?php if ($main_menu): ?>
      <li><a href="#main-menu" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>
<!-- /#skipnav -->

<?php if ($main_menu || $logo || $site_name): ?>
<div id="main-menu" class="clearfix">
  <div class="container">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
        <?php if ($logo || $site_name): ?>
          <a class="brand scroller" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
          <?php if ($logo): ?><img id="logo" src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" role="presentation" /><?php endif; ?>
          <?php if ($site_name): ?><span id="site-name"><?php print $site_name; ?></span><?php endif; ?>
          </a>
        <?php endif; ?>
        <div class="nav-collapse"><?php print render($main_menu_expanded); ?></div>
      </div>
    </div>
  </div>
</div>
<!-- /#main-menu -->
<?php endif; ?>

<?php if ($search || $secondary_menu): ?>
<div id="secondary-menu" class="clearfix>
  <div class="container">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="brand">
          <a class="social-icon feed" href="http://feeds.feedburner.com/Jamesarmescom"></a>
          <a class="social-icon facebook" href="https://www.facebook.com/jamesiarmes"></a>
          <a class="social-icon twitter" href="https://twitter.com/jamesiarmes"></a>
          <a class="social-icon linkedin" href="http://www.linkedin.com/in/jamesiarmes"></a>
          <a class="social-icon gplus" href="https://plus.google.com/107218188126434571464"></a>
          <a class="social-icon flickr" href="http://www.flickr.com/photos/jamesiarmes"></a>
          <a class="social-icon github" href="https://github.com/jamesiarmes"></a>
          <a class="social-icon drupal" href="http://drupal.org/user/284457"></a>
        </div>
        <?php if ($search): ?>
          <div id="nav-search pull-right">
            <?php if ($search): print render($search); endif; ?>
          </div>
        <?php endif; ?>
        <div class="nav-collapse"><?php print render($secondary_menu_expanded); ?></div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div id="header" class="clearfix">
  <?php if (!empty($page['header']) || !empty($page['navigation'])): ?>
    <div class="container">
      <div class="row">
        <div class="<?php if (!empty($page['navigation'])): print 'span8'; else: print 'span12'; endif; ?>">
          <?php if ($site_name || $site_slogan): ?>
          <?php endif; ?>
          <?php if (!empty($page['header'])): ?>
            <div id="header-content" class="row-fluid">
              <?php print render($page['header']); ?>
            </div>
            <!-- /#header-content -->
          <?php endif; ?>
        </div>
        <?php if (!empty($page['navigation'])): ?>
          <div id="navigation" class="span4">
            <?php print render($page['navigation']); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
<!-- /#header -->

<div id="main" class="clearfix">
  <div class="container">
    <?php if ($breadcrumb): ?>
    <div id="breadcrumb"><?php print $breadcrumb; ?></div>
    <?php endif; ?>
    <?php if (!empty($page['main_top'])): ?>
    <div id="main-top" class="row-fluid"> <?php print render($page['main_top']); ?> </div>
    <?php endif; ?>
    <?php if (!empty($page['main_upper'])): ?>
    <div id="main-upper" class="row-fluid"> <?php print render($page['main_upper']); ?> </div>
    <?php endif; ?>
    <div id="main-content" class="row">
      <?php if (!empty($page['sidebar_first'])): ?>
      <div id="sidebar-first" class="sidebar span3">
        <div class="row-fluid"><?php print render($page['sidebar_first']); ?></div>
      </div>
      <!-- /#sidebar-first -->
      <?php endif; ?>
      <div id="content" class="<?php if (!empty($page['sidebar_first']) && !empty($page['sidebar_second'])): print 'span6'; elseif (!empty($page['sidebar_first']) || !empty($page['sidebar_second'])): print 'span9'; else: print 'span12'; endif; ?>">
        <div id="content-wrapper">
          <div id="content-head" class="row-fluid">
            <div id="highlighted" class="clearfix"><?php print render($page['highlighted']); ?></div>
            <?php print render($title_prefix); ?>
            <?php if ($title): ?>
            <h1 class="title" id="page-title"> <?php print $title; ?> </h1>
            <?php endif; ?>
            <?php print render($title_suffix); ?>
            <?php if ($tabs): ?>
            <div class="tabs"> <?php print render($tabs); ?> </div>
            <?php endif; ?>
            <?php if ($messages): ?>
            <div id="console" class="clearfix"><?php print $messages; ?></div>
            <?php endif; ?>
            <?php if (!empty($page['help'])): ?>
            <div id="help" class="clearfix"> <?php print render($page['help']); ?> </div>
            <?php endif; ?>
            <?php if ($action_links): ?>
            <ul class="action-links">
              <?php print render($action_links); ?>
            </ul>
            <?php endif; ?>
          </div>
          <?php if (!empty($page['content_top'])): ?>
          <div id="content-top" class="row-fluid"> <?php print render($page['content_top']); ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content_upper'])): ?>
          <div id="content-upper" class="row-fluid"> <?php print render($page['content_upper']); ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content']) || !empty($feed_icons)): ?>
          <div id="content-body" class="row-fluid"> <?php print render($page['content']); ?> <?php print $feed_icons; ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content_row2'])): ?>
          <div id="content-row2" class="row-fluid"> <?php print render($page['content_row2']); ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content_col2-1']) || !empty($page['content_col2-2'])): ?>
          <div id="content-col2" class="row-fluid">
            <?php if (!empty($page['content_col2-1'])): ?>
            <div class="span6">
              <div id="content-col2-1" class="span12 clearfix clear-row"> <?php print render($page['content_col2-1']); ?> </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page['content_col2-2'])): ?>
            <div class="span6">
              <div id="content-col2-2" class="span12 clearfix clear-row"> <?php print render($page['content_col2-2']); ?> </div>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if (!empty($page['content_row3'])): ?>
          <div id="content-row3" class="row-fluid"> <?php print render($page['content_row3']); ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content_col3-1']) || !empty($page['content_col3-2']) || !empty($page['content_col3-3'])): ?>
          <div id="content-col3" class="row-fluid">
            <?php if (!empty($page['content_col3-1'])): ?>
            <div class="span4">
              <div id="content-col3-1" class="span12 clearfix clear-row"> <?php print render($page['content_col3-1']); ?> </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page['content_col3-2'])): ?>
            <div class="span4">
              <div id="content-col3-2" class="span12 clearfix clear-row"> <?php print render($page['content_col3-2']); ?> </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page['content_col3-3'])): ?>
            <div class="span4">
              <div id="content-col3-3" class="span12 clearfix clear-row"> <?php print render($page['content_col3-3']); ?> </div>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if (!empty($page['content_row4'])): ?>
          <div id="content-row4" class="row-fluid"> <?php print render($page['content_row4']); ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content_col4-1']) || !empty($page['content_col4-2']) || !empty($page['content_col4-3']) || !empty($page['content_col4-4'])): ?>
          <div id="content-col4" class="row-fluid">
            <?php if (!empty($page['content_col4-1'])): ?>
            <div class="span3">
              <div id="content-col4-1" class="span12 clearfix clear-row"> <?php print render($page['content_col4-1']); ?> </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page['content_col4-2'])): ?>
            <div class="span3">
              <div id="content-col4-2" class="span12 clearfix clear-row"> <?php print render($page['content_col4-2']); ?> </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page['content_col4-3'])): ?>
            <div class="span3">
              <div id="content-col4-3" class="span12 clearfix clear-row"> <?php print render($page['content_col4-3']); ?> </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page['content_col4-4'])): ?>
            <div class="span3">
              <div id="content-col4-4" class="span12 clearfix clear-row"> <?php print render($page['content_col4-4']); ?> </div>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if (!empty($page['content_lower'])): ?>
          <div id="content-lower" class="row-fluid"> <?php print render($page['content_lower']); ?> </div>
          <?php endif; ?>
          <?php if (!empty($page['content_bottom'])): ?>
          <div id="content-bottom" class="row-fluid"> <?php print render($page['content_bottom']); ?> </div>
          <?php endif; ?>
        </div>
        <!-- /#content-wrap -->
      </div>
      <!-- /#content -->
      <?php if (!empty($page['sidebar_second'])): ?>
      <div id="sidebar-second" class="sidebar span3">
        <div class="row-fluid"><?php print render($page['sidebar_second']); ?></div>
      </div>
      <!-- /#sidebar-second -->
      <?php endif; ?>
    </div>
    <?php if (!empty($page['main_lower'])): ?>
    <div id="main-lower" class="row-fluid"> <?php print render($page['main_lower']); ?> </div>
    <?php endif; ?>
    <?php if (!empty($page['main_bottom'])): ?>
    <div id="main-bottom" class="row-fluid"> <?php print render($page['main_bottom']); ?> </div>
    <?php endif; ?>
  </div>
</div>
<!-- /#main, /#main-wrapper -->
<?php if (!empty($page['footer'])): ?>
<div id="footer" class="clearfix">
  <div class="container">
    <div id="footer-content" class="row-fluid"> <?php print render($page['footer']); ?> </div>
  </div>
</div>
<!-- /#footer -->
<?php endif; ?>
