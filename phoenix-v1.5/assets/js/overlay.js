jQuery(function($) {
  /*  var triggerBttn = document.getElementById( 'trigger-overlay' ),
        triggerBttnTwo = document.getElementById( 'trigger-overlay-two' ),
        triggerBttnThree = document.getElementById( 'trigger-overlay-three' ),
        triggerBttnFour = document.getElementById( 'trigger-overlay-four' ),
        triggerBttnFive = document.getElementById( 'trigger-overlay-five' ),
        triggerBttnSix = document.getElementById( 'trigger-overlay-six' ),
        triggerBttnSeven = document.getElementById( 'trigger-overlay-seven' ),
*/
      var  overlay = document.querySelector( 'div.overlay' ) || '';
      if(typeof overlay == 'string') return;
       var closeBttn = overlay.querySelector( 'a.overlay-close' );
       var closeBttn2 = overlay.querySelector( 'a.overlay-close.bottom' );
    transEndEventNames = {
        'WebkitTransition': 'webkitTransitionEnd',
        'MozTransition': 'transitionend',
        'OTransition': 'oTransitionEnd',
        'msTransition': 'MSTransitionEnd',
        'transition': 'transitionend'
    },
        transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
        support = { transitions : Modernizr.csstransitions };

    function toggleOverlay() {
        if( classie.has( overlay, 'open' ) ) {
            classie.remove( overlay, 'open' );
            classie.add( overlay, 'close' );
            var onEndTransitionFn = function( ev ) {
                if( support.transitions ) {
                    if( ev.propertyName !== 'visibility' ) return;
                    this.removeEventListener( transEndEventName, onEndTransitionFn );
                }
                classie.remove( overlay, 'close' );
            };
            if( support.transitions ) {
                overlay.addEventListener( transEndEventName, onEndTransitionFn );
            }
            else {
                onEndTransitionFn();
            }
        }
        else if( !classie.has( overlay, 'close' ) ) {
            classie.add( overlay, 'open' );
        }

        $("div.overlay").animate({ scrollTop: 0 }, "slow");
    }
    $('.overlay-ajax[data-toggle="modal"]').on('click', toggleOverlay);
  /*  triggerBttn.addEventListener( 'click', toggleOverlay );
    triggerBttnTwo.addEventListener( 'click', toggleOverlay );
    triggerBttnThree.addEventListener( 'click', toggleOverlay );
    triggerBttnFour.addEventListener( 'click', toggleOverlay );
    triggerBttnFive.addEventListener( 'click', toggleOverlay );
    triggerBttnSix.addEventListener( 'click', toggleOverlay );
    triggerBttnSeven.addEventListener( 'click', toggleOverlay );
*/

    closeBttn.addEventListener( 'click', toggleOverlay );
    if (closeBttn2 != undefined && closeBttn2 != null) {
    closeBttn2.addEventListener('click', toggleOverlay );
    }
    return false;
});
