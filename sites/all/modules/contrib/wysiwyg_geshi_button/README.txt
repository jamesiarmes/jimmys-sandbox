1.) At the moment all SOURCECODES will be displayed, they are NOT syncronized with the geshi module. Meaning if you do not activate php in the geshi settings, you still can chose php in the ckeditor dialog, but it will not work.
I recommend activating most and eventualle customized the array in the plugin.js. I have found no better way by now. SOlutions are welcome.


2.) In the Geshi settings, activate
- Container tag style : <foo> ... </foo> 
- Code container, wrapping technique: ESHI_HEADER_PRE: uses a <pre> wrapper, efficient whitespace coding, no automatic line wrapping, generates invalid HTML with line numbering. 

Languages must have the format: <as3> <php> and so on


3.) The plugin depends on the following geshi tags (use these in the geshi settings)

Language Geshi settings :http://www.your-domain.com/admin/config/content/geshifilter/languages

first is name, second is the name that MUST BE USED IN THE GESHI LANGUAGE SETTINGS

