@extends('app')

@section('main')
<section class="sidebar">

    <h1>Your Classes</h1>
    @foreach($classes as $class)
    <div class="class-box" data-class-id="{{ $class->id }}" data-class-notes="{{ $class->notes }}" data-students="{{ $class->no_of_students }}">
        <div class="class-name-container">
            <div class="class-name">{{ $class->name }}</div>
        </div>
        <div class="inner-class-box clearfix">
            @if($class->lessons->count() <= 0)
                <div class="topic-box no-link">You have no lessons for this class yet! Click the 'Add New Lesson' button below to create one.</div>
            @endif

            @foreach($class->lessons->unique('subject') as $lesson)

                <div class="topic-box" data-topic-id="{{ $lesson->subject }}">{{ $lesson->subject }}</div>

            @endforeach
            <div class="controls clearfix">
                <a href="{{ route('lesson.create', ['id' => $class->id]) }}"><div class="control-button add-new-lesson">Add New Lesson</div></a>
                <div class="control-button add-students-button" style="display:none">Add Students</div>
                <div class="control-button disabled-button bulk-email" style="display:none">Bulk Email Class</div>
                <a class="check delete-link" href="{{ route('classes.destroy', $class->id) }}"><div class="control-button delete"><i class="fa fa-close"></i></div></a>
            </div>
        </div>
        <i class="fa fa-angle-down class-box-switch open"></i>
    </div>
    @endforeach

    <br />
    <div class="class-box" id="add-class">
        <div class="class-name-container">
            <div class="class-name">Add New Programme</div>
        </div>
        <form action="{{ route('classes.store') }}" method="POST" class="clearfix"/>
            {{ csrf_field() }}
            <input type="text" name="class_name" id="class_name" placeholder="Ex. BTEC Level 3 Year 1" required/>

            <input type="number" name="class_number" placeholder="# of Students" min="0" required/>

            <input type="submit" value="Add Class" />
        </form>
    </div>

</section>

<section class="sidebar">
    <h1 id="class-info-title">Class Info </h1>
    <div id="class-info">
        <div id="lesson-details">
            <p>Please select a class from the left.</p>
        </div>
    </div>

    <h1>Lessons</h1>
    <div id="lesson-info">
        <p>Please select a class from the left.</p>
    </div>
</section>

@endsection

@section('extra-scripts')
<script>
$('.check').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var href = $(this).attr('href');
    //var check = prompt("Are you sure you want to delete this programme? WARNING: This is irreversible, and lesson plans created under this class WILL BE DELETED. Please type in DELETE to confirm your choice");
    vex.dialog.prompt({
        message:"Are you sure you want to delete this programme? WARNING: This is irreversible, and lesson plans created under this class WILL BE DELETED. Please type in DELETE to confirm your choice",
        callback:function(value) {
            if(value == "DELETE") {
                    location.href = href;
                }
        }
    })
});

$('.sidebar').on('click', '.check', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');

    //var check = prompt("Are you sure you want to delete this programme? WARNING: This is irreversible, and lesson plans created under this class WILL BE DELETED. Please type in DELETE to confirm your choice");
    vex.dialog.open({
        message:"Are you sure you want to delete this lesson? WARNING: This is irreversible.",
        buttons:[
                    $.extend({}, vex.dialog.buttons.YES, {text: 'Delete'}),
                    $.extend({}, vex.dialog.buttons.NO, {text: 'Cancel'})
                ],
        callback:function(value) {
            if(value) {
                    location.href = href;
                }
        }
    })
});

$('.topic-box').not('.no-link').on('click', function(e) {
    e.stopPropagation();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:'lesson/get',
        type:'POST',
        data: {
            class_id:$(this).parent().parent().attr('data-class-id'),
            topic:$(this).attr('data-topic-id')
        },
        success:function(res) {

            var json = JSON.parse(res);
            var table = "";



            table += "<table style='width:100%'><thead><tr><th></th><th></th><th>Date</th><th>Topic</th><th></th></tr></thead><tbody>";

            for(var i = 0; i< json.length; i++) {

                if(json[i].date == null) {
                    json[i].date = "<i>No date set</i>";
                } else if(moment(json[i].date).diff(moment(new Date()), 'days') > 0) {
                    json[i].date = "<i>"+moment(json[i].date).format('Do MMMM YYYY')+"</i>";
                } else {
                    json[i].date = "<i class='past'>"+moment(json[i].date).format('Do MMMM YYYY')+"</i>";
                }
                table += "<tr>";
                table += "<td style='width:50px'><a href='lesson/edit/"+json[i].id+"'><i class='fa fa-edit'></i></a><br/><br/><a href='lesson/copy/"+json[i].id+"'><i class='fa fa-plus'></i></a></td>";
                table += "<td style='width:50px'><a href='wordGenerator/lessonPlan/"+json[i].id+"'><i class='fa fa-download' style='color:#7AC943;font-size:21px'></i></a><br/><br/><i data-id='"+json[i].secret_key+"' class='fa fa-envelope-square email-plan' style='color:#F89406;font-size:21px'></i></td>";
                //table += "<td style='width:50px'><a href='lesson/copy/"+json[i].id+"'><i class='fa fa-plus'></i></a></td>";
                table += "<td style='width:150px'>"+(json[i].date)+"</td>";
                table += "<td>"+json[i].topic+"</td>";
                /*                    table += "<td>"+((json[i].objectives == null) ? "<i class='fa fa-close'></i>" : "<i class='fa fa-check'></i>")+"</td>";*/
                table += "<td style='width:50px'><a class='check' href='lesson/destroy/"+json[i].id+"'><i class='fa fa-close'></i></a></td>";
                table += "<tr>";
            }

            table += "</tbody></table>";

            table += "<a class='blue-button' href='wordGenerator/schemeOfWork/"+json[0].class_id+"/"+json[0].id+"'>Generate Scheme of Work</a>";

            $('#lesson-info').html(table);


        }
    })
});


$('#class-info-title').on('click', '.edit-class-button', function(e) {
    e.stopPropagation();
    var name = $(this).data('name');
    var number = $(this).data('no-of-students');
    var id = $(this).data('id');
    var notes = ($(this).data('notes') == "No Notes") ? "" : $(this).data('notes');

    var thisE = $(this);
    vex.dialog.open({
        message:'Enter the details you wish to change the values to, then click submit.',
        input: '\
                <input type="hidden" name="id" value="'+id+'" />\
                Name of Programme:<br />\
                <input name="name" type="text" placeholder="Name" value="'+name+'" required /> \
                Number of Students: <Br/>\
                <input name="number" type="text" placeholder="Number of Students" value="'+number+'" required /> \
                Notes: <Br/>\
                <textarea name="notes" placeholder="Ex. Class does not enjoy visual lessons. Use mostly kinesthetic materials. Mark T requires LSA.">'+notes+'</textarea> \
            ',
        buttons:[
            $.extend({}, vex.dialog.buttons.YES, {text: 'Update'}),
            $.extend({}, vex.dialog.buttons.NO, {text: 'Cancel'})
        ],
        callback:function(data) {
            console.log(data);
            if(data != false) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'classes/update/'+data.id,
                    type:'POST',
                    data: {
                        name:data.name,
                        number:data.number,
                        notes:data.notes
                    },
                    failure:function(r) {
                        console.log(r);
                    },
                    success:function(res) {
                        console.log(res);
                        location.reload();

                    }
                })
            }
        }
    });
});

$('.add-students-button').on('click', function(e) {
    e.stopPropagation();
    var id = $(this).parent().parent().parent().parent().data('class-id');
    vex.dialog.open({
        message:'Enter the full name and email address of the student, or ask the student to click on this link to register themselves.',
        input: '\
                <input type="hidden" name="class_id" value="'+id+'" />\
                Full Name of Student:<br />\
                <input name="students_name" type="text" placeholder="Students Full Name" required /> \
                Students Email Address: <Br/>\
                <input name="students_email_address" type="text" placeholder="Students Email Address" required /> \
            ',
        buttons:[
            $.extend({}, vex.dialog.buttons.YES, {text: 'Enroll Student'}),
            $.extend({}, vex.dialog.buttons.NO, {text: 'Close'})
        ],
         onSubmit: function(e) {
            vex.showLoading();

            // Prevent dialog from closing now
            e.preventDefault();
            // Asychronously close this dialog
            // (uses `setTimeout`, but could be `$.ajax` instead)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'classes/addStudent',
                type:'POST',
                data: {
                    name:$('input[name="students_name"]').val(),
                    email:$('input[name="students_email_address"]').val()
                },
                error:function(r) {
                    console.log(r);
                    vex.hideLoading();
                    showErrorBox(r.responseText);
                },
                success:function(res) {
                    console.log(res);
                    vex.hideLoading();
                    showSuccessBox("Student Successfully Added!")
                }
            })
        }
    });
});

$('.class-name-container').on('click', function(e) {
    var parent = $(this).parent();
    var inner = $(this).next();

    if(parent.hasClass("open")) {
        parent.removeClass("open");
        parent.height("40px");
    } else {
        parent.addClass("open");
        parent.height($(inner).height() + 65 + "px");
    }

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:'classes/get',
        type:'POST',
        data: {
            id:$(this).parent().attr('data-class-id')
        },
        success:function(res) {
            var json = JSON.parse(res);

             $('#lesson-details').html("");
             var notes = (json[0].notes == "") ? "No Notes" : json[0].notes;
            $('#lesson-details').prepend("<b>Name:</b> "+json[0].name+"<br /><b>Number of Students:</b> "+json[0].no_of_students+"<br/><b>Notes:</b> "+ notes + "<br />");

            $('#class-info-title').html("Class Info <i data-name='"+json[0].name+"' data-no-of-students='"+json[0].no_of_students+"' data-notes='"+ notes +"' data-id='"+json[0].id+"' class='fa fa-edit edit-class-button'></i>");
        }
    })
});

$('#lesson-info').on('click', '.email-plan', function() {
    var id = $(this).attr('data-id');
    vex.dialog.open({
            message:'Who would you like to send this lesson plan to?',
            input: '\
                    <input type="hidden" name="id" value="'+id+'" />\
                    Email:<br />\
                    <input name="email" type="email" placeholder="Email" required="" /> \
                ',
            buttons:[
                $.extend({}, vex.dialog.buttons.YES, {text: 'Send'}),
                $.extend({}, vex.dialog.buttons.NO, {text: 'Cancel'})
            ],
            callback:function(data) {

                if(data != false) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url:'lesson/send',
                        type:'POST',
                        data: {
                            email:data.email,
                            id:data.id
                        },
                        failure:function(r) {
                            console.log(r);
                        },
                        success:function(res) {
                            console.log(res);
                            showSuccessBox("Success! Your lesson plan has been sent.");

                        }
                    })
                }
            }
        });
});

//INTRO STAGE 2
var intro = introJs();
  intro.setOptions({
  skipLabel:'Skip Tutorial',
  doneLabel:'Skip Tutorial',
    steps: [
        {
            step:4,
            intro: "<h2>Classes!</h2><p>When you create a class, this page will list and allow you to create lessons for your classes.</p>",
            position:'bottom'
        },
        {
            element:'#add-class',
            intro: "<p>But we don't have any classes yet! Let's start by making one. You can click here to do this!</p>"
        },{
            element:'#add-class',
            intro:"<p><b>Programme Name:</b> The name of the qualification, or some other form of unique identification of your class. For example, City & Guilds Level 1, or BTEC Level 3 Year 2</p><p>We'll also need the <b>number of students</b> in the class. This can all be edited in the future.</p><p>When you're done, press the 'Add Class' button.",
            position:'right'
        }
    ]
  });

  intro.onexit(function() {
           showInformationBox("Remember, you can re-activate the tutorial through the 'View Account' page.");
           $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });

            $.ajax({
                type:'POST',
                url:'{{ route('account.finishTutorial') }}'
            })
         });

if({{ \Illuminate\Support\Facades\Auth::user()->tutorial }} == 2) {
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



//INTRO STAGE 3
var addedClass = $('.class-box:last').prev().prev().attr('id', 'last-class');
var intro2 = introJs();
  intro2.setOptions({
  skipLabel:'Skip Tutorial',
  doneLabel:'Skip Tutorial',
    steps: [
        {
            element:'#last-class',
            intro: "<h2>Nice!</h2><p>You've created your first class for your <b>"+$('#last-class .class-name').html()+"</b> students! Now lets set up one of their lessons.</p><p>Click to view options for your new class.</p>",
            position:'bottom'
        },
        {
            element:'#last-class',
            intro: "<p><b>Add New Lesson</b> will add a new lesson for this class.</p><p><b>Edit class info</b> will allow you to change the name, amount of students, as well as add any class specific notes.</p><p>Finally, the <b>big <span style='color:red'>red</span> button </b> will delete this class.</p><p><b>Lets create a lesson</b></p>",
            position:'right'
        }
    ]
  });

  intro2.onexit(function() {
           showInformationBox("Remember, you can re-activate the tutorial through the 'View Account' page.");
           $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });

            $.ajax({
                type:'POST',
                url:'{{ route('account.finishTutorial') }}'
            })
         });

if({{ \Illuminate\Support\Facades\Auth::user()->tutorial }} == 3) {
    intro2.start();
    var temp2 = true;
}

$('.class-box:last').prev().prev().on('click', function() {
    if(temp2) {
    setTimeout(function() {
        intro2.nextStep();
    }, 150);
    temp2 = !temp2;
    }
})

//INTRO STAGE 5
var addedClass = $('.class-box:last').prev().prev().attr('id', 'last-class');
var addedClass = $('.class-box:last').prev().prev().attr('id', 'last-class');
var intro3 = introJs();
  intro3.setOptions({
  skipLabel:'Skip Tutorial',
  doneLabel:'Finish Tutorial!',
    steps: [
        {
            element:'#last-class',
            intro: "<h2>Nice!</h2><p>We've created your lesson! Why dont you click and have a look...</p>",
            position:'bottom'
        },
        {
            element:'#last-class',
            intro: "<p>Classistant automatically groups your lessons together through their unit name. As you create more lessons, you'll see many more units here! For now, lets click the first unit we've created.</p>",
            position:'right'
        },
        {
            element:'#lesson-info',
            intro: "<p>Now we can see all the lessons under this unit!</p>" +
             "<p>Clicking the <b>green download button</b> furthest to the left will download a Microsoft Word document with your lesson details.</p>" +
              "<p>Next, the <b>top edit button</b> will bring you back to the lesson creation screen, allowing you to continue working on your lesson plan.</p>" +
               "<p>Below that, the <b>bottom plus button</b> will copy this lesson plan, putting the date one week further. You can then edit this lesson, setting it to another class, or using the pre-existing data as reference when writing a lesson recap!</p>" +
                "<p>To the far right is the <b>delete button</b>.<p>Why dont you download the plan to see what it looks like?</p>",
            position:'left'
        },
        {
            intro: "<h2>We're done!</h2><p>Congratulations! You've created your first class, lesson and can now continue to create more!</p><p><h2>Final notes</h2><p>If you haven't already, you may want to change your password. This can be done through the 'View Account' link to the top-left.</p><p>Also, if you find a bug, a link to a bug-report form is available at the bottom of the navigation bar.</p><p>Thanks for using Classistant! More features will be coming soon - all aimed to make your teaching life easier!",
            position:'left'
        }
    ]
  });

  intro3.onexit(function() {
           showInformationBox("Remember, you can re-activate the tutorial through the 'View Account' page.");
           $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });

            $.ajax({
                type:'POST',
                url:'{{ route('account.finishTutorial') }}'
            })
         }).oncomplete(function() {
                      showInformationBox("Remember, you can re-activate the tutorial through the 'View Account' page.");
                      $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                       $.ajax({
                           type:'POST',
                           url:'{{ route('account.finishTutorial') }}'
                       })
                    });

if({{ \Illuminate\Support\Facades\Auth::user()->tutorial }} == 5) {
    intro3.start();
    var temp3 = true;
    var temp4 = true;
}

$('.class-box:last').prev().prev().on('click', function() {
    if(temp3) {
    setTimeout(function() {
        intro3.nextStep();
    }, 150);
    temp3 = !temp3;
    }
})

$('.class-box:last').prev().prev().find('.topic-box').on('click', function() {
    if(temp4) {
    setTimeout(function() {
        intro3.nextStep();
    }, 500);
    temp4 = !temp4;
    }
})
</script>
@endsection
