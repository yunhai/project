if ("undefined" == typeof jQuery) {  
    console.log("Error: Require jQuery library - mExtend");
}else{
    (function($){
        $(document).ready(function(){
            // ---------------- Init var ---------------- 
            var statusMExtend = false; // True: Opened / False: Closed
            var classOpenMExtend = '.open-m-extend';
            var classMExtend = '.m-extend';
            var classCloseMExtend = '.close-m-extend';
            var classMExtendActive = '.m-extend-active';
            var classNameMExtendActive = 'm-extend-active';
            var classMExtendOverlay = '.m-extend-overlay';
            var idMExtend = '.m-exptend';

            // ---------------- Open MExtend ---------------- 
            $(classOpenMExtend).click(function(){
                // Get ID will Open
                idMExtend = $(this).attr('data-fix-extend');
                // -------- Add active -------- 
                $(idMExtend).addClass(classNameMExtendActive);
                $(classMExtendOverlay).addClass(classNameMExtendActive);
                // Disable scroll page when scroll MExtend
                $('body').css({
                    'overflow':'hidden',
                });
            });

            // ---------------- Close MExtend ----------------  
            // -------- Touch overlay -------- 
            $(classMExtendOverlay).swipeend(function(e,touch){
                if(touch.direction == "left"){
                    // hidden MExtend
                    $(classMExtend).removeClass(classNameMExtendActive)
                    // Hidden overlay
                    $(this).removeClass(classNameMExtendActive);
                }
                // Enble scroll page when scroll MExtend
                $('body').css({
                    'overflow':'auto',
                });
            });
            // -------- Click -------- 
            $(classCloseMExtend).click(function(){
                // hidden MExtend
                $(classMExtend).removeClass(classNameMExtendActive)
                // Hidden overlay
                $(classMExtendOverlay).removeClass(classNameMExtendActive);
                // Enble scroll page when scroll MExtend
                $('body').css({
                        'overflow':'auto',
                });
            });
        }); // end document ready
    })(jQuery);
} // end check jQuery library exsist