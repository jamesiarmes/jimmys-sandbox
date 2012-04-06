(function($) {

  /**
   * Adds a CKEditor plugin to insert geshi formatted code.  
   * 
   * we use <pre class="php> ... </pre> to highlight the code. Where php is the llanguage
   * we can not use [php]... [/php] style because ckeditor will kill and reformat that   * 
   * check info @ .module files for the NAMING like used here "geshiButton", you must sync that with the module code
   * 
   */
  
  CKEDITOR.plugins.add('geshiButton', 
  {      
        init: function (editor) 
        {            
            //adding a command to the button
            editor.addCommand( 'geshibutton',new CKEDITOR.dialogCommand( 'geshiDialog' ) ); 
            
          //add the button to ckeditor ui                  
          editor.ui.addButton('geshibutton', 
          {
            label: Drupal.t('Syntaxhighlight'),
            command: 'geshibutton',
            icon: this.path + 'images/geshiv1.png'
          } );
      
  
  //The Dialog
  // the name, here 'geshiDialog' is the same as in CKEDITOR.dialogCommand( 'geshiDialog' )
  
  CKEDITOR.dialog.add( 'geshiDialog', function ( editor )
  {
	return {
		title : 'Geshi Properties',
		minWidth : 600,
		minHeight : 600,
 
		contents : 
                [
                    {
                        id : 'general',
                        label : 'Settings',                        
                        elements :
                        [
                        
                            {
                                type : 'html',
                                // HTML code to be shown inside the field.
                                // http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.dialog.html.html#constructor
                                html : 'This dialog window lets you create Higlighted Sourcecode'
                            },
                            {                              
                                      id: 'lang',
                                      type: 'select',
                                      labelLayout: 'horizontal',
                                      label: 'Language',
                                      'default': 'php',
                                      widths : [ '25%','75%' ],
                                      items: [
                                               [ 'actionscript' , 'actionscript' ],         
                                               [ 'actionscript2' , 'actionscript3' ], 
                                               [ 'apache' , 'apache' ],                                               
                                               [ 'asp' , 'asp' ],
                                               [ 'bash' , 'bash' ],                                              
                                               [ 'c' , 'c' ],
                                               [ 'cpp' , 'cpp' ],
                                               [ 'csharp' , 'csharp' ],
                                               [ 'css' , 'css' ],                                               
                                               [ 'delphi' , 'delphi' ],
                                               [ 'drupal6' , 'drupal6' ],
                                               [ 'drupal5' , 'drupal5' ],
                                               [ 'diff' , 'diff' ],
                                               [ 'dos' , 'dos' ],                               
                                               [ 'html4strict' , 'html4strict' ],
                                               [ 'html5' , 'html5' ],
                                               [ 'ini' , 'ini' ],
                                               [ 'java' , 'java' ],
                                               [ 'javascript' , 'javascript' ],           
                                               [ 'jquery' , 'jquery' ],      
                                               [ 'latex' , 'latex' ],                                               
                                               [ 'lua' , 'lua' ],
                                               [ 'matlab' , 'matlab' ],  
                                               [ 'mxml' , 'mxml' ],
                                               [ 'mysql' , 'mysql' ],                                               
                                               [ 'Objective-C ' , 'objectivec ' ],                                              
                                               [ 'pascal' , 'pascal' ],
                                               [ 'perl' , 'perl' ],
                                               [ 'perl6' , 'perl6' ],
                                               [ 'php' , 'php' ],                                          
                                               [ 'python' , 'python' ],                                              
                                               [ 'ms registry' , 'reg' ],
                                               [ 'robots.txt' , 'robots' ],
                                               [ 'ruby' , 'ruby' ],                                               
                                               [ 'smarty' , 'smarty' ],                     
                                               [ 'sql' , 'sql' ],          
                                               [ 'text' , 'text' ],      
                                               [ 'typoscript' , 'typoscript' ],     
                                               [ 'vb' , 'vb' ],
                                               [ 'vbnet' , 'vbnet' ],
                                               [ 'xml' , 'xml' ],                                                                    
                                             ],                                             
                                
                                      
                                      commit: function(data) {
                                          data.lang = this.getValue();
                                      }
                               
                            },
                            
                            {
                                    type : 'html',
                                    html : 'Bitte keine starttags wie in php z.B üblich mit einbinden.'		
                            },

                            {
                                type: 'textarea',
                                id: 'contents',
                                // Validation checking whether the field is not empty.
				validate : CKEDITOR.dialog.validate.notEmpty( 'Das Feld darf nicht leer sein.' ),
                                required : true,
                                rows: 40,
                                style: "width: 100%",                                
                             
                                
                                commit: function(data) {
                                    data.contents = this.getValue();
                                }
                            }
                        ]
                    },       
        ],

 
  
  //ok button
  onOk : function()
    {
            var dialog = this,
            data = {},
            geshiCode = editor.document.createElement( 'pre' );
            
            this.commitContent( data );
            
            // Insert the Displayed Text entered in the dialog window into the pre element.
	    // http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setHtml
	    geshiCode.setHtml( data.contents );
            geshiCode.setAttribute( 'class', data.lang );
           
            // Insert the link element into the current cursor position in the editor.
	    // http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertElement
            
	    editor.insertElement( geshiCode );          
    }
  
  
  	}; // end return
        
  }); //end dialog
  
  } // end init
  
  }); // end CKEDITOR.plugins.add
  
})(jQuery);


