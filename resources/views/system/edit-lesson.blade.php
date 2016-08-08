@extends('app')
@section('extra-head')
<link rel="stylesheet" href="{{ asset('/css/pickadate/default.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/pickadate/default.date.css') }}" />

<link rel="stylesheet" href="{{ asset('/css/timepicker/jquery.timepicker.css') }}" />
@endsection
@section('main')

 <form class="lesson-creator" action="{{ route('lesson.update', ['id' => $lesson[0]->id]) }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="lessonId" value="1" />
    <section class="sidebar" id="lesson-details">

        @foreach($lesson as $less)
        <h1>Lesson Details</h1>
        <label for="class">Class:</label>
        <select name="class">
            @foreach($classes as $class)
                <option value="<?= $class['id'] ?>" <?= (((isset($less['class_id'])) ? (($less['class_id'] == $class['id']) ? "selected" : "") : "")) ?>><?= $class['name'] ?></option>
            @endforeach
        </select>

        <label for="subject">Unit:</label>
        <input type="text" name="subject" id="subject" list="subjects" value="<?= $less['subject'] ?>" placeholder="Unit #: Personal Development" />

        <datalist id="subjects">
            <?php foreach($subjects as $s) : ?>
            <option value="<?= $s['subject'] ?>">
                <?php endforeach; ?>
        </datalist>


        <label for="topic">Topic:</label>
        <input type="text" name="topic" id="topic" value="<?= $less['topic'] ?>" placeholder="What is the title for this lesson?"/>


        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="{{ ($less['date'] == null) ? '' : $less['date']->format('j F, Y') }}" placeholder="DD/MM/YYYY"/>

        <label for="room">Room Number:</label>
        <input type="text" name="room" id="room"  value="<?= $less['room'] ?>" placeholder="4.012"/>

        <label for="startTime">Time Start</label>
        <input type="text" name="startTime" id="startTime"  value="<?= $less['time_start'] ?>" placeholder="--:--am"/>

        <label for="endTime">Time End:</label>
        <input type="text" name="endTime" id="endTime"  value="<?= $less['time_end'] ?>" placeholder="--:--am"/>
        <div class="niceEdit-wrapper">
             <h1>Objectives:</h1>
                            <p style="margin-bottom:0px;">You should write here about the primary objectives of this lesson. We provide a standard template you can use - click to the suggestions button to view it.</p>
                            <div class="objectives-helper">Suggestions</div>
            <textarea name="objectives" id="objectives" style="height:440px;"><?= $less['objectives'] ?></textarea>
            <br /><br/>
            <h1>Notes ( LSA Instructions ):</h1>
            <textarea name="notes" id="notes"><?= $less['notes'] ?></textarea>
        </div>
        <br/>
        <div class="private-box">
        <p>Your lesson plan gets automatically listed in our public search directory - so other teachers can view your work to aid in their own learning.<br /><br/> You may tick this box to prevent this lesson from being listed: <input type="checkbox" name="private" id="private" <?= $less['private'] == "1" ? "checked" : "" ?>/></p>
        </div>


      
        <br/> <Br/> <br/>
    </section>
    @endforeach

    <section class="sidebar">
    <h1>Writing Stages</h1>
                        <p>As part of the standards to creating exceptional lesson plans, you are required to color code certain sections of your activities depending on the development the activity is offering. </p>
                        <p>
                            Lessons should demonstrate:
                            <ul>
                                <li>Development of <span class="english-and-maths">English and/or Mathematics</span></li>
                                <li>Promotion of <span class="equality-and-diversity">Equality &amp; Diversity</span></li>
                                <li>Students actively checking <span class="learning-and-progress">Learning &amp; progress</span></li>
                            </ul>
                        </p>
        <h1>Stages Details</h1>
        <div class="stages">
            <?php if(count($lesson_stages) <= 0) : ?>
                <div class="stage" data-amount="1">
                    <button class="minus" onclick="return removeStage(this)">Remove</button><br/>
                    <label for="stage">Stage:</label>
                    <input type="text" name="stage_name[]" value="1. "/>



                    <label for="stage">Activities:</label>
                    <div class="helper">Suggestions</div>
                    <textarea name="activities[]" class="activities" id="act1"></textarea><br/>

                    <label for="resources">Resources:</label>
                    <input type="text" name="resources[]" class="resources-input"/>

                </div>
                 <div class="stage" data-amount="2">
                    <button class="minus" onclick="return removeStage(this)">Remove</button><br/>
                    <label for="stage">Stage:</label>
                    <input type="text" name="stage_name[]" value="2. "/>

                    <label for="stage">Activities:</label>
                    <textarea name="activities[]" class="activities" id="act1"></textarea><br/>

                    <label for="resources">Resources:</label>
                    <div class="helper">Suggestions</div>
                    <input type="text" name="resources[]" class="resources-input"/>

                </div>
            <?php endif; ?>
            <?php foreach($lesson_stages as $stage) : ?>
                <div class="stage" data-amount="<?=  $stage['order_no'] ?>">
            <button class="delete" onclick="return removeStage(this)"><i class="fa fa-close"></i></button><br/>
            <label for="stage">Stage:</label>
            <input type="text" name="stage_name[]" value="<?= $stage['stage'] ?>"/>


            <label for="stage">Activities:</label>
            <div class="helper">Suggestions</div>
            <textarea name="activities[]" class="activities" id="act<?= $stage['order_no'] ?>"><?= $stage['activity'] ?></textarea><br/>

            <label for="resources">Resources:</label>
            <input type="text" name="resources[]" class="resources-input" value="<?= $stage['resources'] ?>"/>

                </div>
            <?php endforeach; ?>

        </div>
        <button class="plus" onclick="return addStage()">Add Stage</button><br/><br/>

        <input type="submit" value="Save" class="save-button"/>

        <a href="{{ route('lesson.generateDoc', ['id' => $less['id']]) }}">
            <div class="download-button">Download Word Document</div>
        </a>
        <br/><br/><br/>
    </section>

</form>

@endsection

@section('extra-scripts')
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('/js/nicEdit.js') }}"></script>
<script src="{{ asset('/js/pickadate/legacy.js') }}"></script>
<script src="{{ asset('/js/pickadate/picker.js') }}"></script>
<script src="{{ asset('/js/pickadate/picker.date.js') }}"></script>

<script src="{{ asset('/js/timepicker/jquery.timepicker.min.js') }}"></script>

<script>
    $('#date').pickadate({
        formatSubmit: 'yyyy\-mm\-dd',
        hiddenName:true
    });
    $('#startTime').timepicker({
            'step':15
        }) ;
        $('#endTime').timepicker({
            'step':15,
            'minTime':($('#startTime').val() == "") ? 0 : $('#startTime').val()
        })
</script>
<script>
    bkLib.onDomLoaded(function() {

        new nicEditor({
            buttonList : ['fontSize','bold','italic','underline','strikeThrough', 'ol', 'ul', 'bgcolor'],
            externalCSS:'../css/main.css',
            maxHeight:220
        }).panelInstance('notes');

        new nicEditor({
            buttonList : ['fontSize','bold','italic','underline','strikeThrough', 'ol', 'ul', 'bgcolor'],
            externalCSS:'../css/main.css',
            maxHeight:440
        }).panelInstance('objectives');
    });
    var activityAreas = {};
    function makeActivityAreas() {

        $('.activities').each(function() {
            new nicEditor({
                buttonList: ['fontSize', 'bold', 'italic', 'underline', 'strikeThrough', 'ol', 'ul', 'bgcolor'],
                externalCSS: '../css/main.css',
                maxHeight: 220
            }).panelInstance(this.id);
        });
    }
    makeActivityAreas();

</script>
<script>
    function addStage() {
             var count = parseInt($('.stages .stage').last().attr('data-amount')) + 1;
            $('.stages').append('<div class="stage" data-amount="'+count+'">\
                <button class="delete" onclick="return removeStage(this)"><i class="fa fa-close"></i></button><br/>\
                <label for="stage">Stage:</label>\
                <input type="text" name="stage_name[]" value="'+(count+1)+'. "/>\
        \
                <label for="stage">Activities:</label>\
                <div class="helper">Suggestions</div>\
                <textarea name="activities[]" class="activities" id="act'+count+'"></textarea><br/>\
        \
                <label for="resources">Resources:</label>\
                <input type="text" name="resources[]" class="resources-input"/>\
            </div>');

            new nicEditor({
                buttonList: ['fontSize', 'bold', 'italic', 'underline', 'strikeThrough', 'ol', 'ul', 'bgcolor'],
                externalCSS: '../css/main.css',
                maxHeight: 220
            }).panelInstance('act'+count);
            return false;
        }

    function removeStage(element) {
        $(element).parent().remove();
        return false;
    }

   /* $(function() {

        $(window).on('keydown', function(e) {
            console.log(e.keyCode);
            $('.download-button').html("Save before downloading!").css('background', '#888888').parent().prop('href', '#');

            if(e.keyCode == 83 && e.ctrlKey) {
                e.preventDefault();
                $('.lesson-creator').submit();
            }
        });

        var availableTags = [
            "Internet",
            "MS OFFICE",
            "Flipchart",
            "Projector",
            "VB6",
            "VS2005",
            "Handout",
            "Antistatic Kit",
            "Worksheets",
            "Video nuggets",
            "Lab equipment",
            "E-Labs",
            "Virtual drives",
            "Installation software",
            "Computer",
            "Case Studies",
            "Whiteboard"
        ];
        function split( val ) {
            return val.split( /,\s*//* );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }

        $( ".resources-input" )
            // don't navigate away from the field on tab when selecting an item
            .bind( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    response( $.ui.autocomplete.filter(
                        availableTags, extractLast( request.term ) ) );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
    });*/
</script>

<script>

     var firstStageActivities = [
            "Welcome class to lesson",
            "Take Register",
            "Collect Homework"
        ];
        var mainStageActivities = [
            "Powerpoint Presentation",
            "Work on Assignment",
            "Independent Study",
            "Discussion between whole class" ,
            "Discussion within groups" ,
            "Thoughtshare between peers" ,
            "Practical task: .." ,
            "Lecture on .." ,
            "Question and answer sessions" ,
            "Demonstration of ..." ,
            "Peer Assessment ...",
            "Self Assessment ...",
            "Debate on ..." ,
            "Group Work: .." ,
            "Role Play: ..." ,
            "Quiz: ...",
            "Examination: ...",
        ];

        $('.stages').on('click', '.helper', function() {
            var stageId = $(this).parent().data('amount');
            var input = "";
            var suggestions = mainStageActivities;

            if($(this).parent().is('.stage:first-of-type')) {
                suggestions = firstStageActivities;
            }

            suggestions.forEach(function(element) {
                input += "<span class='add-suggestion' data-stage-id='"+stageId+"'>"+element+"</span>";
            });

            vex.dialog.open({
                message:"Let us help you create your lesson plans! Choose the activities you wish to include in your lessons below.",
                input:input,
                buttons:[
                    $.extend({}, vex.dialog.buttons.YES, {text: 'Finish'})
                ],
                callback:function(value) {

                }
            })
        });

         $('body').on('click', '.add-suggestion', function() {
            console.log($(this));
                if(!$(this).hasClass('selected')) {
                    $('.stage[data-amount='+$(this).data('stage-id')+']').find('.nicEdit-main').append($(this).html() + "<br />");
                    $(this).addClass('selected');
                }
            });

        $('.objectives-helper').on('click', function() {
            $('#lesson-details').find('.nicEdit-main').first().append("<b>There must be sufficient stretch and challenge so that by the end of the lesson:</b> " +

                                                               "<br/><br/><b>All Students will be able to </b><br />" +

                                                               "..." +
                                                                "<ul>" +
                                                               "<li>_______</li>" +
                                                               "<li>_______</li>" +
                                                               "<li>_______</li>" +
                                                               "</ul>" +
                                                               "<br/><b>Most Students will be able to </b><br />" +

                                                               "..." +

                                                               "<br /><Br /><b>Some Students will be able to </b><br />" +

                                                               "..."

                                                               );

        });
</script>
@endsection