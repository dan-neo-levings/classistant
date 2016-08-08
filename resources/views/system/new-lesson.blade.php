@extends('app')
@section('extra-head')
<link rel="stylesheet" href="{{ asset('/css/pickadate/default.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/pickadate/default.date.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/timepicker/jquery.timepicker.css') }}" />
@endsection
@section('main')
<form class="lesson-creator" action="{{ route('lesson.store') }}" method="POST">
        {{ csrf_field() }}
        <section class="sidebar" id="lesson-details">

                <h1>Lesson Details</h1>
                <label for="class">Class:</label>
                <select name="class" required>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selectedId == $class->id ? " selected" : "" }}>{{ $class->name }}</option>
                    @endforeach
                </select>

                <label for="subject">Unit:</label>
                <input type="text" name="subject" id="subject" list="subjects" value="{{ isset($baseLesson) ? $baseLesson->subject : "" }}" placeholder="Unit #: Personal Development" required/>
                <datalist id="subjects">
                    <?php foreach($subjects as $s) : ?>
                        <option value="{{ $s->subject }}">
                    <?php endforeach; ?>
                </datalist>

                <label for="topic">Topic:</label>
                <input type="text" name="topic" id="topic" list="topics" value="{{ isset($baseLesson) ? $baseLesson->topic : "" }}" placeholder="What is the title for this lesson?"/>

                <label for="date">Date:</label>
                <input type="text" name="date" id="date" placeholder="DD/MM/YYYY"/>

                <label for="room">Room Number:</label>
                <input type="text" name="room" id="room" placeholder="4.012"/>

                <label for="startTime">Time Start</label>
                <input type="text" name="startTime" id="startTime" placeholder="--:--am"/>

                <label for="endTime">Time End:</label>
                <input type="text" name="endTime" id="endTime" placeholder="--:--am" />
<div class="niceEdit-wrapper" id="tutorial-3">

                <h1>Objectives:</h1>
                <p style="margin-bottom:0px;">You should write here about the primary objectives of this lesson. We provide a standard template you can use - click to the suggestions button to view it.</p>
                <div class="objectives-helper">Suggestions</div>
                <textarea name="objectives" id="objectives" style="height:420px" >{!! isset($baseLesson) ? $baseLesson->objectives : '' !!}</textarea>
                <br /><br />
                <h1>Notes ( LSA Instructions ):</h1>

                <textarea name="notes" id="notes">{!! isset($baseLesson) ? $baseLesson->notes : '' !!}</textarea>


</div>
<br />
<div class="private-box">
                    <p>Your lesson plan gets automatically listed in our public search directory - so other teachers can view your work to aid in their own learning.<br /><br/> You may tick this box to prevent this lesson from being listed: <input type="checkbox" name="private" id="private" /></p>
                </div>
        </section>

        <section class="sidebar">
        <div  id="stage-details">
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
                    </div>
                    <h1>Stages Details</h1>
                    <div class="stages">
                    @if(isset($baseLesson) && $baseLesson->stages->count() > 0)
                    @foreach($baseLesson->stages as $stage)
                     <div class="stage" data-amount="<?=  $stage['order_no'] ?>">
                        <button class="delete" onclick="return removeStage(this)"><i class="fa fa-close"></i></button><br/>
                        <label for="stage">Stage:</label>
                        <input type="text" name="stage_name[]" value="<?= $stage['stage'] ?>" />


                        <label for="stage">Activities:</label>
                        <div class="helper">Suggestions</div>
                        <textarea name="activities[]" class="activities" id="act<?= $stage['order_no'] ?>"><?= $stage['activity'] ?></textarea><br/>

                        <label for="resources">Resources:</label>
                        <input type="text" name="resources[]" class="resources-input" value="<?= $stage['resources'] ?>"/>

                     </div>
                     @endforeach
                    @else

                        <div class="stage" data-amount="1">
                            <button class="delete" onclick="return removeStage(this)"><i class="fa fa-close"></i></button><br/>
                            <label for="stage">Stage:</label>
                            <input type="text" name="stage_name[]" value="1. " />

                            <label for="stage">Activities:</label>
                             <div class="helper">Suggestions</div>
                            <textarea name="activities[]" class="activities" id="act1"></textarea><br/>

                            <label for="resources">Resources:</label>
                            <input type="text" name="resources[]" class="resources-input"/>

                        </div>

                        <div class="stage" data-amount="2">
                            <button class="delete" onclick="return removeStage(this)"><i class="fa fa-close"></i></button><br/>
                            <label for="stage">Stage:</label>
                            <input type="text" name="stage_name[]" value="2."/>


                            <label for="stage">Activities:</label>
                             <div class="helper">Suggestions</div>
                            <textarea name="activities[]" class="activities" id="act2"></textarea><br/>

                            <label for="resources">Resources:</label>
                            <input type="text" name="resources[]" class="resources-input"/>

                        </div>

                    @endif
                    </div>
                    <button class="plus" onclick="return addStage()" id="add-stage-button">Add Stage</button><br/><br/>
<input type="submit" value="Save" class="save-button"/>
                </section>
    </form>

<div class="help-circle">
    <i class="fa fa-question-circle"></i>
</div>
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
                <input type="text" name="stage_name[]" value="'+(count)+'. "/>\
        \
                <label for="stage">Activities:</label>\
                <div class="helper">Suggestions</div> \
                <textarea name="activities[]" class="activities" id="act'+count+'"></textarea><br/>\
        \
                <label for="resources">Resources:</label>\
                <input type="text" name="resources[]" class="resources-input"/>\
                \
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

//    $(function() {
//        var availableTags = [
//            "Internet",
//            "MS OFFICE",
//            "Flipchart",
//            "Projector",
//            "VB6",
//            "VS2005",
//            "Handout",
//            "Antistatic Kit",
//            "Worksheets",
//            "Video nuggets",
//            "Lab equipment",
//            "E-Labs",
//            "Virtual drives",
//            "Installation software",
//            "Computer",
//            "Case Studies",
//            "Whiteboard"
//        ];
//        function split( val ) {
//            return val.split( /,\s*/ );
//        }
//        function extractLast( term ) {
//            return split( term ).pop();
//        }
//
//        $( ".resources-input" )
//            // don't navigate away from the field on tab when selecting an item
//            .bind( "keydown", function( event ) {
//                if ( event.keyCode === $.ui.keyCode.TAB &&
//                    $( this ).autocomplete( "instance" ).menu.active ) {
//                    event.preventDefault();
//                }
//            })
//            .autocomplete({
//                minLength: 0,
//                source: function( request, response ) {
//                    // delegate back to autocomplete, but extract the last term
//                    response( $.ui.autocomplete.filter(
//                        availableTags, extractLast( request.term ) ) );
//                },
//                focus: function() {
//                    // prevent value inserted on focus
//                    return false;
//                },
//                select: function( event, ui ) {
//                    var terms = split( this.value );
//                    // remove the current input
//                    terms.pop();
//                    // add the selected item
//                    terms.push( ui.item.value );
//                    // add placeholder to get the comma-and-space at the end
//                    terms.push( "" );
//                    this.value = terms.join( ", " );
//                    return false;
//                }
//            });
//    });

    $(window).on('keydown', function(e) {
            if(e.keyCode == 83 && e.ctrlKey) {
                e.preventDefault();
                $('.lesson-creator').submit();
            }
        });


    //INTRO STAGE 3
    var intro = introJs();
      intro.setOptions({
      skipLabel:'Skip section',
        steps: [
            {
                intro: "<p>Welcome to the Lesson Creation area!</p><p>Here you will fill in all the details of the lesson you want to create. This is a large page, so let us take you through it.</p>",
                position:'bottom'
            },
            {
                element:'#lesson-details',
                intro: "<h2>Lesson Details #1</h2><p>To the left, you can fill in all the standard details of your lesson.</p>" +
                 "<p>The <b>Class</b> is automatically filled in for you from the previous page.</p>" +
                  "<p>The <b>Unit</b> is the unit of the qualificaiton, for example, Unit 1: Personal and Professional Development.</p>" +
                   "<p>The <b>Topic</b> is the title of the whole lesson. Following the example, this could be 'Writing a CV', or 'Importance of Soft Skills'</p>" +
                    "<p>The <b>Date, Room Number, Time Start and Time End</b> are fairly simple, generic details about the lesson.</p>",
                position:'right'
            },{
                element:'#tutorial-3',
                intro:"<h2>Lesson Details #2</h2><p>The <b>Objectives</b> should provide a clear outline of the outcomes of the lesson. This should include 'All/Most/Some students should know' points.</p>" +
                 "<p><b>Notes</b> are optional extra pieces of information about the lesson. When the lesson plan is generated, any class specific notes are also included within this area automatically.</p>",
                position:'right'
            },{
                element:'.private-box',
                intro:"<h2>Lesson Details #3</h2><p>Your lesson automatically gets put into our search directory. In providing this we hope to give other teachers within your college and other colleges assistance in their own lesson planning.</p>" +
                 "<p>We recommend you allow us to place your lessons for all to see - credit is given to you and is also visible in searches - however if you do not wish for your lessons to be publicly available, check the box here.</p>",
                position:'top'
            },{
                element:'#stage-details',
                intro:"<h2>Stage Details #1</h2><p>Next is stage details. We have some helpful information to help you write your stages to make them to an exceptional standard in the eyes of Ofsted. </p>",
                position:'left'
            },{
                element:'#first-stage',
                intro:"<h2>Stage Details #2</h2><p>Within these boxes you are able to write your stage details, including Stage Name, Activities involved and resources required. Of course, your lessons will need multiple stages within them.</p>",
                position:'left'
            },{
                element:'#add-stage-button',
                intro:"<h2>Stage Details #3</h2><p>You can press this button to add as many stages as your lesson requires.</p>",
                position:'left'
            },{
                element:'#first-delete-button',
                intro:"<h2>Stage Details #4</h2><p>As well as this, you can delete stages as to your requirements.</p>",
                position:'left'
            },{
                element:'.save-button',
                intro:"<h2>Finished?</h2><p>You can save this lesson and come back later to work on it at any time! You can also press CTRL+S to save.</p>",
                position:'top'
            },{
                intro:"<h2>Thats it!</h2><p>Now we can continue to fill in these details!</p><p>Alternately, if you're just going through this tutorial and don't have time, we can fill this in with some dummy data for you!</p><p> (It wont fill all fields in, but thats okay! You can still save and continue)</p><p> <button onclick='dummyDataFill()'>Fill with dummy data</button></p><p>When you're done, click save to continue with the tutorial.",
                position:'left'
            }

        ]
      });


    if({{ \Illuminate\Support\Facades\Auth::user()->tutorial }} == 4) {
        $('.stage').first().attr('id', 'first-stage');
        $('.stage').first().find('.delete').attr('id', 'first-delete-button');
        intro.start();
    }
    var temp = true;
    $('#add-class').on('click', function() {
        if(temp) {
        setTimeout(function() {
            intro.nextStep();
        }, 150);
        temp = !temp;
        }
    })

    function dummyDataFill() {
        console.log("Filled!");
        $('input[name="subject"]').val("Human Computer Interaction");
        $('input[name="topic"]').val("Effect on HCI on society, economy and culture");
        $('input[id="date"]').val("9 February, 2016");
        $('input[name="room"]').val("T4.102");
        $('input[name="startTime"]').val("4:00 PM");
        $('input[name="endTime"]').val("5:00 PM");
    }

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
        "Thoughtshare" ,
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
        console.log($('#lesson-details'))
    });
</script>
@endsection