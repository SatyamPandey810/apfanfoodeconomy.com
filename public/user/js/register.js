
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
      var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
      curInputs = curStep.find("input[type='text'], input[type='url'], select, textarea, input[type='radio'],input[type='password']"),
      isValid = true;
      curInputs.each(function() {
        if ($(this).is('select')) { // If it's a select element
            if ($(this).val() == null) { // If no option is selected
                isValid = false;
                return false; // Exit the loop
            }
        } else { // For other input types
            if (!$(this).val()) { // If the value is empty
                isValid = false;
                return false; // Exit the loop
            }
        }
    });

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-success').trigger('click');
});

// tell the embed parent frame the height of the content
if (window.parent && window.parent.parent){
    window.parent.parent.postMessage(["resultsFrame", {
      height: document.body.getBoundingClientRect().height,
      slug: "59e5e1ya"
    }], "*")
  }

  // always overwrite window.name, in case users try to set it manually
  window.name = "result"

  let allLines = []

      window.addEventListener("message", (message) => {
        if (message.data.console){
          let insert = document.querySelector("#insert")
          allLines.push(message.data.console.payload)
          insert.innerHTML = allLines.join(";\r")

          let result = eval.call(null, message.data.console.payload)
          if (result !== undefined){
            console.log(result)
          }
        }
      })

      const customConsole = (w) => {
        const pushToConsole = (payload, type) => {
          w.parent.postMessage({
            console: {
              payload: stringify(payload),
              type:    type
            }
          }, "*")
        }

        w.onerror = (message, url, line, column) => {
          line = line - 70
          if (line < 0){
            pushToConsole(message, "error")
          } else {
            pushToConsole(`[${line}:${column}] ${message}`, "error")
          }
        }

        let console = (function(systemConsole){
          return {
            log: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "log")
              systemConsole.log.apply(this, args)
            },
            info: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "info")
              systemConsole.info.apply(this, args)
            },
            warn: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "warn")
              systemConsole.warn.apply(this, args)
            },
            error: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "error")
              systemConsole.error.apply(this, args)
            },
            system: function(arg){
              pushToConsole(arg, "system")
            },
            clear: function(){
              systemConsole.clear.apply(this, {})
            },
            time: function(){
              let args = Array.from(arguments)
              systemConsole.time.apply(this, args)
            },
            assert: function(assertion, label){
              if (!assertion){
                pushToConsole(label, "log")
              }

              let args = Array.from(arguments)
              systemConsole.assert.apply(this, args)
            }
          }
        }(window.console))

        window.console = { ...window.console, ...console }

        console.system("Running fiddle")
      }

      if (window.parent){
        customConsole(window)
      }
