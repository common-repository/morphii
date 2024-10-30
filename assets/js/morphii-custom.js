(function(window, document, undefined) {
  'use strict';
  jQuery.noConflict();
  var collection = null;
  var intensitySet=false;
  var morphiiInstance;
  window.onload = function() {
    createWidget();

    // Add change event to language selection.
    var langSelection = document.getElementById('language-selection');
    if (langSelection) {
      langSelection.addEventListener('change', langSelectionChange);
    }

    // Call submit function when Submitt button is clicked.
    var submitButton = document.getElementById('morphii-submit-button');
    if (submitButton) {
      submitButton.addEventListener('click', submit);

      // Disable submit button util a morphii is selected.
      submitButton.setAttribute('disabled', 'disabled');
    }
  }

  function langSelectionChange(event) {
    if (collection) {
      var lang = document.getElementById('language-selection').value;
      collection.language(lang);
    }
  }

  // Define the widget options.
  function widgetOptions(qId) {
    var queID = qId.split("q_");
    var morphiisIdentifires = document.getElementById('questioned-morphiies_'+queID[1]).value;
    if(morphiisIdentifires !== ""){
      var split_str = morphiisIdentifires.split(",");
      var unique_names = [ ...new Set(split_str.map(name => {
         return { id: name.split('-')[0] }
      }))]
    }
	morphiiInstance={
      div_id: 'widget-' + qId,
      morphii: {
        ids: unique_names,
        show_name: true, 
        wrap_name: true
      },
      target : {
        id: qId,
        type : 'question'
      },
      comment: {
        show: false, 
        required: false
      },
      slider: {
        initial_intensity: 0.5,
        show_animation: true,
        anchor_labels: {
          show: false
        }
      },
	  intensity: {
            required: true
        },
      selection: {
        required: true
      },
      instructions: {
        show: true
      },
      options: {
        stage: 'test'
      }
    };
    return morphiiInstance;
  }

  function createWidget() {
    var morphii_account_key,
    element1 = document.getElementById('morphii_account_key');
    if (element1 != null) {
        morphii_account_key = element1.value;
    }
    else {
        morphii_account_key = null;
    }

    var morphii_account_id,
    element2 = document.getElementById('morphii_account_id');
    if (element2 != null) {
        morphii_account_id = element2.value;
    }
    else {
        morphii_account_id = null;
    }
    // var morphii_account_key = document.getElementById('morphii_account_key').value;
    // var morphii_account_id = document.getElementById('morphii_account_id').value;
    var collectionOptions = {
      client_key: morphii_account_key,
      account_id: morphii_account_id,
      project: {
        id: 'widget-sample',
        description: 'Sample widget code.'
      },
      application: {
        name: 'sample-application',
        description: 'Sample demo of Widget v2.',
        version: '1.0'
      },
      user: {
        id: 'user-id'
      },
      callbacks: {
        error: errorCallback,
        selection_change: selectionChangeCallback
      }
    };

    collection = new MorphiiWidgets.Collection();
    collection.init(collectionOptions, function(error, valid) {
      if (valid === true) {
        var ids = jQuery('.morphii-questions').map(function(){
            return this.id;
        }).get();
        // Add the widget to each question on the page.
        ids.forEach(function(qId) {
          var option = widgetOptions(qId);
          collection.add(option, function(error, results) {
            if (error) {
              console.log('Collection add error: ' + JSON.stringify(error, null, 2));
            }
            else {
              var divId = results.configuration.div_id;
              var targetId = results.configuration.target.id;

              // The target id (in the widget options) was set as the element id
              // for the question text.
              var questionText = document.getElementById(targetId).textContent;

              // Add additional metadata to widget.
              collection.addMetadata(divId, 'question_id', targetId);
              collection.addMetadata(divId, 'question', questionText);

              // collection.addMetadata(divId, 'foo1', 'bar1');
              // collection.addMetadata(divId, 'foo2', 'bar2');
              // collection.addMetadata(divId, 'foo3', 'bar3');
            }
          });
        });
      }
      else {
        console.log('Init error: ' + JSON.stringify(error, null, 2));
      }
    });
  }

  // The Collection widget error callback
  function errorCallback(error) {
    console.log('Error callback: ' + JSON.stringify(error, null, 2));
  }

  // Selection Change callback
  function selectionChangeCallback(event) {
    //console.log('Selection Change callback: ' + JSON.stringify(event, null, 2));
	var submitButton = document.getElementById('morphii-submit-button');
    if (submitButton) {
    
      if (event.selection_required_valid === true) {

        submitButton.removeAttribute('disabled');
      }
      else {
		  

        submitButton.setAttribute('disabled', 'disabled');
      }
    }
    

	
  }

  function submit(event) {
	
	var noUiOrigin=document.getElementsByClassName('noUi-origin')[0];
	
	  if(morphiiInstance.slider.initial_intensity*100!=parseInt(noUiOrigin.style.left) || jQuery("#slider_moved").val()=='yes'){
		  intensitySet=true;
		  jQuery("#slider_moved").val('yes');
	  }
	  else{
		  jQuery("#slider_moved").val('no');
	  }
	 
	  if(intensitySet && jQuery("#slider_moved").val()=="yes"){
	   jQuery(".morphii-questions").find(".intensity-error").remove();
	
	  }
		else{
		  if(jQuery(".morphii-questions").find(".intensity-error").length==0)
	  {
		  jQuery(".morphii-questions").append("<span class='intensity-error'><br/><hr/><p style='color:red'>Oops! You forgot to tell us how intense your feelings are. Use the slider to adjust the facial expression to show us</p></span>");	 
		  return false;
	  }
	   return false;
	  }
	  
    if (collection) {
      var submitButton = document.getElementById('morphii-submit-button');
      var product_id = jQuery('#morphii_product_id').val();
      // var user_id = jQuery('#morphii-current-user').val();
      // var user_name = jQuery('#morphii-user-name').val();
      // var user_email = jQuery('#morphii-user-email').val();

      var current_post_type = jQuery('#morphii-current-post_type').val();
      var current_post_id = jQuery('#morphii-current-post_id').val();
      var current_post_name = jQuery('#morphii-current-post_name').val();

      var comments = jQuery('.morphii-user_message').map(function(){
            return { id: this.id, text: this.val};
      }).get();
      // if(user_name === '' || user_email === ''){
      //   submitButton.setAttribute('disabled', 'disabled');
      //   if(user_name === '' || user_name === undefined || user_name === null){
      //     jQuery('#morphii-error-user-name').text('Name is required. Please Enter Your Name.');
      //   }

      //   if(user_email === '' || user_email === undefined || user_email === null){
      //     jQuery('#morphii-error-user-email').text('Email is required. Please Enter Your Email.');
      //   }        
      //   return false;
      // }      

      submitButton.removeAttribute('disabled');
      collection.submit(function(error, results) {
          if (error) {
            //console.log('Submit results (error): ' + JSON.stringify(error, null, 2));
          }
          else {
            var mainRecord = JSON.stringify(results, null, 2);
            var length = results.length;
            for (var i = 0; i < length; i++) {
              var record = results[i];
              if (record && record.submitted === true) {
                // console.log('Submit record: ' + JSON.stringify(record, null, 2));
                // console.log('Results for target id: ' + record.target_id);
                // console.log('reaction id: ' + record.reaction_id);
                if (record.reaction_record) {
                  // console.log('morphii id: ' + record.reaction_record.morphii.id);
                  // console.log('morphii part name: ' + record.reaction_record.morphii.part_name);
                  // console.log('morphii display name: ' + record.reaction_record.morphii.display_name);
                  // console.log('morphii intensity: ' + record.reaction_record.morphii.intensity);
                  if (record.reaction_record.comment) {
                    // console.log('comment locale: ' + record.reaction_record.comment.locale);
                    // console.log('comment text: ' + record.reaction_record.comment.text);
                  }
                  else {
                    console.log('No comment provided');
                  }
                }
                else {
                  console.log('Subscription for this account has expired or reached the reaction limit.');
                }
              }
              else {
                // console.log('Morphii data not submitted.');
                // console.log('Submit results: ' + JSON.stringify(record, null, 2));
              }
            }

            jQuery(function($) {
                $.noConflict();
                $.ajax({
                  url: ajax_object.ajaxurl,
                  dataType: "json",
                  type: "POST",
                  data:{ 
                    action: 'submit_reviews',
                    nonce: ajax_object.nonce,
                    product_id: product_id,
                    // user_name: user_name,
                    // user_email: user_email,
                    // user_id: user_id,
                    mainRecord: mainRecord,
                    comments: comments,
                    current_post_type: current_post_type,
                    current_post_id: current_post_id,
                    current_post_name: current_post_name
                  },
                  success: function( data ){
                    $('.SuccessFormSubmitMorphii').text(data.message);
                    $('#review_form').hide();
                    $('.SuccessFormSubmitMorphii').show();
                    $('.ErrorFormSubmitMorphii').hide();
                  },
                  error: function(MLHttpRequest, textStatus, errorThrown) {
                    $('.ErrorFormSubmitMorphii').text(errorThrown);
                    $('#review_form').hide();
                    $('.SuccessFormSubmitMorphii').hide();
                    $('.ErrorFormSubmitMorphii').show();
                  }
                });
            });
          }
      });
    }
  }
})(window, document);