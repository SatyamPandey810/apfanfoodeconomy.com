particlesJS('particles-js',
  {
    "particles": {
      "number": {
        "value": 100,  
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#ffffff"  
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        },
        "polygon": {
          "nb_sides": 5  
        },
        "image": {
          "src": "",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.8,  
        "random": true,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.3,
          "sync": false
        }
      },
      "size": {
        "value": 20,  
        "random": true,
        "anim": {
          "enable": false,
          "speed": 20,
          "size_min": 4,  
          "sync": false
        }
      },
      "line_linked": {
        "enable": false  
      },
      "move": {
        "enable": true,
        "speed": 1, 
        "direction": "bottom",  
        "random": true,
        "straight": false,
        "out_mode": "out",  
        "bounce": false,
        "attract": {
          "enable": false,
          "rotateX": 600,
          "rotateY": 1200
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": false 
        },
        "onclick": {
          "enable": false  
        },
        "resize": true
      }
    },
    "retina_detect": true,
    "config_demo": {
      "hide_card": false,
      "background_color": "#000",  
      "background_image": "",
      "background_position": "50% 50%",
      "background_repeat": "no-repeat",
      "background_size": "cover"
    }
  }
);