jQuery(function() {

  /**
   * Slideshow for the first page
   *
   */
  var slideShow = (function(){
    var cssId = '#slideshow', 
      wrapper,
      image,
      orig,
      host,
      path,
      images,
      nr,
      intervalId = null,
      current = 0,
      zindex = 0,
      pause = false,
      durationSlide = 4000,
      durationPause = 9000,
      durationFirst = durationPause,
      easing='linear',
    
      rotate = function() {
      $(cssId + ' img')
        .eq(current)
        .fadeOut(durationSlide, function() {
          $(this)
            .css('z-index', zindex - nr + 1)
            .fadeIn(0)
            .siblings().each(function() {
              $(this).css('z-index', ((parseInt($(this).css('z-index')) + 1)));
            });
        });
        current = (current + 1) % nr;
        intervalId = window.setTimeout(rotate, durationPause);
      },

      togglePause = function(){
        pause = !pause;
        if(!pause) {
          console.log("Work");
          rotate();
          //intervalId = window.setTimeout(rotate, durationPause);
        } else {
          console.log("Paus");
          window.clearTimeout(intervalId);
        }
      },

      init = function(opts) {
        var i, clone, options = opts || {};

        console.log("Init");

        cssId         = options.cssId ||cssId;
        durationSlide = options.durationSlide || durationSlide;
        durationPause = options.durationPause || durationPause;
        durationFirst = options.durationFirst || durationFirst;

        wrapper = $(cssId);
        image   = $(cssId + ' img');
        orig    = image.attr('src');
        host    = wrapper.data('host');
        path    = wrapper.data('path');
        images  = wrapper.data('images');
        nr      = images.length + 1;

        current = 0;
        wrapper.css('position', 'relative');
        image.css('position', 'relative');        
        image.css('top', '0');
        image.css('left', '0');
        zindex = parseInt(image.css('z-index')) | 0;
        image.css('z-index', zindex);
        clone = image.clone();
        clone.css('position', 'absolute');

        for(i = 0; i < images.length; i++) {
          clone.css('z-index', zindex - i - 1);
          clone.attr('src', host + path + images[i]);
          wrapper.append(clone.clone());
        }

        wrapper.on('click', togglePause);
        intervalId = window.setTimeout(rotate, durationFirst);
      };

      return {
        init: init
      }
  })();


  /**
   * Only init slideshow on first page
   *
   */
  //slideShow.init();
  slideShow.init({"cssId" : "#slideshow", "durationPause" : 4000, "durationSlide" : 2000, "durationFirst" : 4000});

});
