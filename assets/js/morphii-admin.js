jQuery(function() {
    var data = [
        {
            header_name: 'Core/Universal Morphiis',
            description: 'The Core/Universal Morphiis provide the set of foundational emotions that have been shown to exist across cultural and language differences.',
            header_id: '1',
            morphiis: [
              {
                id: '6533704109450043392', 
                name: 'Happy',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Happy'},
                  {id: 2, name: 'Delighted'},
                  {id: 3, name: 'Excited'},
                  {id: 4, name: 'Euphoric'},
                  {id: 5, name: 'Energized'},
                  {id: 6, name: 'Enthusiastic'},
                  {id: 7, name: 'Inspired'},
                  {id: 8, name: 'Elated'},
                  {id: 9, name: 'Thrilled'}
                ]
              },
              {
                id: '6533704269946437632', 
                name: 'Sad',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Sad'}
                ]
              },
              {
                id: '6533701265895370752', 
                name: 'Angry',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Angry'}
                ]
              },
              {
                id: '6533701038905233408', 
                name: 'Afraid',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Afraid'}
                ]
              },
              {
                id: '6533701517217636352', 
                name: 'Disgusted',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Disgusted'}
                ]
              },
              {
                id: '6533704454940164096', 
                name: 'Surprised',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Surprised'}
                ]
              }
            ]
        },
        {
            header_name: 'Customer and Employee Experience (CX and EX)',
            description: 'Experience Morphiis that are commonly used to capture various customer and employee experiences',
            header_id: '2',
            morphiis: [
              {
                id: '6533717440390311936', 
                name: 'Love',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Love'}
                ]
              },
              {
                  id: '6533704109450043392',
                  name: 'Delighted',
                  name_index: 2,
                  labels: [
                    {id: 1, name: 'Happy'},
                    {id: 2, name: 'Delighted'},
                    {id: 3, name: 'Excited'},
                    {id: 4, name: 'Euphoric'},
                    {id: 5, name: 'Energized'},
                    {id: 6, name: 'Enthusiastic'},
                    {id: 7, name: 'Inspired'},
                    {id: 8, name: 'Elated'},
                    {id: 9, name: 'Thrilled'}
                    ]
              },
              {
                  id: '6533717691772903424',
                  name: 'Satisfied',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Satisfied'},
                    {id: 2, name: 'Content'},
                    {id: 3, name: 'Pleased'},
                    {id: 4, name: 'Good'},
                    {id: 5, name: 'Ok'}
                  ]
              },
              {
                  id: '6533717823323430912',
                  name: 'Meh',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Meh'},
                    {id: 2, name: 'Indifferent'},
                    {id: 3, name: 'Unimpressed'},
                    {id: 4, name: 'Fine'},
                    {id: 5, name: 'Uninspired'},
                    // {id: 6, name: 'Ok'},
                    {id: 7, name: 'Undecided'},
                    {id: 8, name: 'Don\'t care'}
                  ]
              },
              {
                  id: '6533717983040057344',
                  name: 'Disappointed',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Disappointed'},
                    {id: 2, name: 'Let down'},
                    {id: 3, name: 'Regret'}
                  ]
              },
              {
                  id: '6533718112033349632',
                  name: 'Worried',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Worried'},
                    {id: 2, name: 'Anxious'},
                    {id: 3, name: 'Nervous'},
                    {id: 4, name: 'Stressed'},
                    {id: 5, name: 'Concerned'},
                    {id: 6, name: 'Afraid'}
                  ]
              },
              {
                  id: '6533718265862295552',
                  name: 'Frustrated',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Frustrated'},
                    {id: 2, name: 'Angry'},
                    {id: 3, name: 'Irritated'},
                    {id: 4, name: 'Annoyed'},
                    {id: 5, name: 'Bothered'}
                  ]
              },
              {
                id: '6533718375584432128', 
                name: 'Hate',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Hate'}
                ]
              },
              {
                  id: '6533718688784474112',
                  name: 'Confused',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Confused'},
                    {id: 2, name: 'Perplexed'}
                  ]
              },
              {
                  id: '6533718878758178816',
                  name: 'Troubled',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Troubled'},
                    {id: 2, name: 'Uneasy'}
                  ]
              },
              {
                  id: '6533723099961516032',
                  name: 'Relaxed',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Relaxed'},
                    {id: 2, name: 'Calm'},
                    {id: 3, name: 'Comfortable'}
                  ]
              }
            ]
        },
        {
            header_name: 'Morphii Insights Model CX',
            description: 'Morphiis used to capture the experiences in the Insights Model for Customer Experience.  These Morphiis should be used as a complete set for appropriate scoring.',
            header_id: '3',
            morphiis: [
              {
                id: '6533704109450043392',
                name: 'Delighted',
                name_index: 2,
                labels: [
                  {id: 1, name: 'Happy'},
                  {id: 2, name: 'Delighted'},
                  {id: 3, name: 'Excited'},
                  {id: 4, name: 'Euphoric'},
                  {id: 5, name: 'Energized'},
                  {id: 6, name: 'Enthusiastic'},
                  {id: 7, name: 'Inspired'},
                  {id: 8, name: 'Elated'},
                  {id: 9, name: 'Thrilled'}
                  ]
            },
            {
                id: '6533717691772903424',
                name: 'Satisfied',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Satisfied'},
                  {id: 2, name: 'Content'},
                  {id: 3, name: 'Pleased'},
                  {id: 4, name: 'Good'},
                  {id: 5, name: 'Ok'}
                ]
            },
            {
                id: '6533717823323430912',
                name: 'Meh',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Meh'},
                  {id: 2, name: 'Indifferent'},
                  {id: 3, name: 'Unimpressed'},
                  {id: 4, name: 'Fine'},
                  {id: 5, name: 'Uninspired'},
                  // {id: 6, name: 'Ok'},
                  {id: 7, name: 'Undecided'},
                  {id: 8, name: 'Don\'t care'}
                ]
            },
            {
                id: '6533717983040057344',
                name: 'Disappointed',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Disappointed'},
                  {id: 2, name: 'Let down'},
                  {id: 3, name: 'Regret'}
                ]
            },
            {
                id: '6533718112033349632',
                name: 'Worried',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Worried'},
                  {id: 2, name: 'Anxious'},
                  {id: 3, name: 'Nervous'},
                  {id: 4, name: 'Stressed'},
                  {id: 5, name: 'Concerned'},
                  {id: 6, name: 'Afraid'}
                ]
            },
            {
                id: '6533718265862295552',
                name: 'Frustrated',
                name_index: 1,
                labels: [
                  {id: 1, name: 'Frustrated'},
                  {id: 2, name: 'Angry'},
                  {id: 3, name: 'Irritated'},
                  {id: 4, name: 'Annoyed'},
                  {id: 5, name: 'Bothered'}
                ]
            },
            {
                  id: '6533723337566945280',
                  name: 'Disgusted',
                  labels: [
                    {id: 1, name: 'Disgusted'},
                    {id: 2, name: 'Contempt'},
                    {id: 3, name: 'Appalled'}
                  ]
              }
            ]
        },
        {
            header_name: 'Mood',
            description: 'Mood states that can be used when asking people how they\'re generally feeling or how well they are doing.',
            header_id: '4',
            morphiis: [
                {
                    id: '6533723521351159808',
                    name: 'Good',
                    name_index: 1,
                    labels: [
                      {id: 1, name: 'Good'},
                      {id: 2, name: 'Happy'},
                      {id: 3, name: 'Positive'},
                      {id: 4, name: 'Fine'},
                      {id: 5, name: 'Well'},
                      {id: 6, name: 'Upbeat'}
                    ]
                },
                {
                    id: '6533723671591751680',
                    name: 'Grumpy',
                    name_index: 1,
                    labels: [
                      {id: 1, name: 'Grumpy'},
                      {id: 2, name: 'Frustrated'},
                      {id: 3, name: 'Annoyed'},
                      {id: 4, name: 'Bad'}
                    ]
                },
                {
                    id: '6533723841286062080',
                    name: 'Low',
                    name_index: 1,
                    labels: [
                      {id: 1, name: 'Low'},
                      {id: 2, name: 'Down'},
                      {id: 3, name: 'Downbeat'},
                      {id: 4, name: 'Tired'},
                      {id: 5, name: 'Solemn'},
                      {id: 6, name: 'Blue'}
                    ]
                },
                {
                    id: '6533723983905464320',
                    name: 'Tense',
                    name_index: 1,
                    labels: [
                      {id: 1, name: 'Tense'},
                      {id: 2, name: 'Anxious'},
                      {id: 3, name: 'Nervous'},
                      {id: 4, name: 'Worried'},
                      {id: 5, name: 'Stressed'}
                    ]
                }
            ]
        },
        {
            header_name: 'More Morphiis',
            description: 'Generally applicable Morphiis that don\'t fit into an existing category.',
            header_id: '5',
            morphiis: [
                {
                    id: '6533724182769438720',
                    name: 'Eye Roll',
                    name_index: 1,
                    labels: [
                      {id: 1, name: 'Eye Roll'},
                      {id: 2, name: 'Bored'},
                      {id: 3, name: 'Cynical'},
                      {id: 4, name: 'Skeptical'},
                      {id: 5, name: 'Doubtful'}
                    ]
                }
            ]
        },
        {
            header_name: 'Multi-Emotion',
            description: 'Multi-Emotion Morphiis provide the ability to report the feeling between two distinct emotional experiences.  These are often helpful where you are looking to understand the intensity of sentiment versus understanding the detailed categories of experiences people are having.',
            header_id: '6',
            morphiis: [
                {
                  id: '6542770352172081152', 
                  name: 'Delighted-Frustrated',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Delighted-Frustrated'}
                  ]
                },
                {
                  id: '6542770446598025216',
                  name: 'Delighted-Disappointed',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Delighted-Disappointed'}
                  ]
                },
                {
                  id: '6544192686898020352',
                  name: 'Delighted-Disgusted',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Delighted-Disgusted'}
                  ]
                },
                {
                  id: '6544191894129311744',
                  name: 'Love-Hate',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Love-Hate'}
                  ]
                },
                {
                  id: '6544193423787802624',
                  name: 'Happy-Angry',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Happy-Angry'}
                  ]
                },
                {
                  id: '6544194156873465856',
                  name: 'Satisfied-Frustrated',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Satisfied-Frustrated'},
                    {id: 2, name: 'Pleased-Annoyed'}
                  ]
                }
            ]
        },
        {
            header_name: 'Static',
            description: 'Static Morphiis provide a non-morphing option that doesn\'t allow setting of intensity.',
            header_id: '7',
            morphiis: [
                {
                  id: '6533724318790193152', 
                  name: 'Neutral',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Neutral'}
                  ]
                },
                {
                  id: '6206533129830662144', 
                  name: 'Can\'t Say',
                  name_index: 1,
                  labels: [
                    {id: 1, name: 'Can\'t Say'}
                  ]
                }
            ]
        },
        // {
        //     comingSoon: true,
        //     header_name: 'Coming Soon',
        //     morphiis: [
        //         // {name: 'Curious'}
        //     ]
        // }
    ];

    var divPanel = '<div class="morphii-list-group">';
    var ul = '<ul class="morphii-list">';
    var ulEnd = '</ul>';
    var h2 = '<h2>';
    var h2End = '</h2>';
    var div = '<div>';
    var divEnd = '</div>';
    var selectHtml = '<select>';
    var selectEndHtml = '</select>';

    var container = document.getElementById('morphii-list-container');
    var selectedMorphiis;
    var selectedMorps = document.getElementById('selected-morphiies');
    if (selectedMorps != null) {
        selectedMorphiis = selectedMorps.value;
    } else {
        selectedMorphiis = null;
    }
    data.forEach(function (record) {
        var html = divPanel + div + h2 + record.header_name + h2End;
        if (record.description) {
            html += `<p class="morphii-group-description">${record.description}</p>`;
        }

        var alternativeLabelsProvided = record.morphiis.some((x) => x.labels && x.labels.length > 1);
        var liClass = alternativeLabelsProvided ? 'alternates' : 'no-alternates';

        html += ul;
        for (var index = 0; index < record.morphiis.length; index++) {
            var morphiiRecord = record.morphiis[index];
            html += `<li class="${liClass}">`;
            html += `<div class="morphii-name">${morphiiRecord.name}</div>`;
            if (record.comingSoon === true) {
                html += '<div class="morphii-list-info">';
                html += '<img src="https://cdn1.morphii.com/morphii/images/coming_soon.jpg" class="morphii-list-image" />';
            }
            else {
                var labelIndex = morphiiRecord.name_index || 1;
                var morphiiId =  (labelIndex === 1) ? morphiiRecord.id : `${morphiiRecord.id}_${labelIndex}`;
                var labelDivId = '_' + Math.random().toString(36).substr(2, 9);
                var imgId = '_' + Math.random().toString(36).substr(2, 9);
                html += '<div class="morphii-list-info">';
               // html += `<div id="${labelDivId}">${morphiiId}</div>`;
                // html += `<img id="${imgId}" src="https://cdn1.morphii.com/morphii/images/coming_soon.jpg" class="morphii-list-image" onClick="changeImage('${morphiiRecord.id}', '${imgId}')"/>`;
                html += `<img id="${imgId}" src="https://cdn1.morphii.com/morphii/images/${morphiiRecord.id}.jpg" class="morphii-list-image" onClick="changeImage('${morphiiRecord.id}', '${imgId}')"/>`;
                var myMorphies = [];
                var myMorphies_next = [];
                if(selectedMorphiis !== null){
                  var split_str = selectedMorphiis.split(",");
                  for (var indexMorps = 0; indexMorps < split_str.length; indexMorps++) {
                    var morp = split_str[indexMorps];
                    var main_id = morp.split("-"); 
                    // if(main_id[0].indexOf('_') === -1){
                    //   var mains = main_id[0].split("_"); 
                    //   myMorphies_next.push(mains[0]);
                    // }else{
                      myMorphies.push(main_id[0]);  
                    //}        
                  } 
                  if(jQuery.inArray(morphiiId, myMorphies) !== -1) {
                    html += `<div class="optional-labels">Select ${morphiiRecord.name}</div><input type="checkbox" class="morphiicheck" name="morphiis[]" id="morphii-${morphiiId}" value="${morphiiId}-${record.header_id}" checked/>`;
                  }else{
                    html += `<div class="optional-labels">Select ${morphiiRecord.name}</div><input type="checkbox" class="morphiicheck" name="morphiis[]" id="morphii-${morphiiId}" value="${morphiiId}-${record.header_id}" />`;
                  }
                }else{
                  html += `<div class="optional-labels">Select ${morphiiRecord.name}</div><input type="checkbox" class="morphiicheck" name="morphiis[]" id="morphii-${morphiiId}" value="${morphiiId}-${record.header_id}" />`;
                }
                
                if (morphiiRecord.labels && morphiiRecord.labels.length > 1) {
                  var myarrayMorphies = [];                  
                  if(selectedMorphiis !== null){
                      var split_str = selectedMorphiis.split(",");
                      for (var indexMorp = 0; indexMorp < split_str.length; indexMorp++) {
                        var morp = split_str[indexMorp];
                        var main_id = morp.split("-");                  
                        myarrayMorphies.push(main_id[0]);            
                      }                        
                  }                
                  labels = morphiiRecord.labels.map((l) => {
                    var selected = (labelIndex === l.id) || (jQuery.inArray(`${morphiiId}`+'_'+`${l.id}`, myarrayMorphies) !== -1) || (jQuery.inArray(`${morphiiId}`, myarrayMorphies) !== -1)? 'selected' : ''; 
                    if(`${l.id}` == 1){
                      return `<option value="${morphiiId}" ${selected}>${l.name}</option>` 
                    }else{
                      return `<option value="${morphiiId}_${l.id}" ${selected}>${l.name}</option>` 
                    }
                  });
                  html += `<div class="optional-labels">Alternate Label Choices</div><input type="hidden" class="header_id" value="${record.header_id}" />
                  <select name="morphiis_label[]" class="morphiis_label">${labels}</select>`;
                }            
            }

            html += `<div>${morphiiRecord.widget_only ? '<strong>Widget Only</strong>' : ''}</div>`;
            html += divEnd;
            html += '</li>';
        }
        html += ulEnd;
        html += divEnd + divEnd;
        if(container != null){
          container.insertAdjacentHTML('beforeend', html);
        }        
    });
});

function changeImage(id, imgId) {
    var jpgImg = `https://cdn1.morphii.com/morphii/images/${id}.jpg`;
    var gifImg = `https://cdn1.morphii.com/morphii/images/${id}.gif`;
    var img = document.getElementById(imgId);
    img.src = (img.src === jpgImg) ? gifImg : jpgImg;
}

jQuery('body').on('change', '.morphiis_label',function() {
  var header_id = jQuery(this).prev('.header_id').val();
  var selected_label = jQuery(this).val();
  var final_morphii_id = selected_label+'-'+header_id;
  jQuery(this).prev().prev().prev('.morphiicheck').val(final_morphii_id);
});