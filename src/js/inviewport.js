
export default $ => {

  let lastScrollTop = 0

  const inViewport = e => {
    
    var b = e.get(0).getBoundingClientRect()
    return !(b.top > window.innerHeight || b.bottom < 0);
  }  

  const checkInViewport = els => {    

    els.each(            
      function() {

        const $this = $(this)
        
        if(inViewport($this)){ 
    
          $this.removeClass('ct-not-in-viewport')
          $this.removeClass('ct-in-viewport')
          $this.addClass('ct-in-viewport')

        } else { 
          
          $this.removeClass('ct-in-viewport')
          $this.removeClass('ct-not-in-viewport')
          $this.addClass('ct-not-in-viewport')
        }
      }
    )    
  }
  
  function init(){
    
    const els = $('.ct-visual')
    
    if(els.length) {

      console.log(els.length)
      
      checkInViewport(els)

      document.addEventListener(
        'scroll',
        function(){

          const st = window.pageYOffset || document.documentElement.scrollTop     
          // const scrollDir = st > lastScrollTop ? 'down' : 'up'
            
          lastScrollTop = st <= 0 ? 0 : st;

          checkInViewport(els)
        }
      )
    }
  } 

  init()
}