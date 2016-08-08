@extends('app')
@section('main')
    <section class="sidebar">
        <h1>Welcome to Classistant!</h1>
        <p>Thank you for being part of the Beta program to create a world-class piece of education software.</p>
        <p>If you encounter any bugs or errors, please report them using the form - a link to this form is on the bottom-right of the screen.</p>
    </section>
    <section class="sidebar" id="tutorial-1">
        <h1>This Weeks Lessons</h1>
        @if($thisWeeksLessons->count() <= 0)
            You have no lessons this week.
        @else

            @foreach($thisWeeksLessons as $date => $lessons)
            <h2>{{ $date }}</h2>
                @foreach($lessons as $lesson)
                <a href="{{ route('lesson.edit', ['id' => $lesson->id]) }}">
                     <div class="this-week-box">
                         <div class="search-unit">{{ $lesson->subject }}</div>
                         <div class="written-by">{{ $lesson->cl->name }}</div>
                         <div class="this-week-time"> {{ $lesson->time_start }} - {{ $lesson->time_end}}</div>
                     </div>
                 </a>
                 @endforeach
            @endforeach
        @endif

    </section>

    {{--<section class="sidebar">
     <h1>Welcome to Classistant!</h1>
     <p>Classistant is your tool for lesson planning. </p>
    </section>--}}

@endsection

@section('extra-scripts')
<script>
function startIntro(){
        var intro = introJs();
          intro.setOptions({
          skipLabel:'Skip Tutorial',
          doneLabel:'Skip Tutorial',
            steps: [
                {
                    intro: "<h2>Hello!</h2><p>As this is your first time using this program, let us give you a guided tour!</p><p> At any time you wish to skip the tutorial, just press the 'Skip Tutorial' button.</p><p> In the future, you can re-enable the tutorial through the 'View Account' page.</p>",
                    position:'bottom'
                },
                {
                    element:'#tutorial-1',
                    intro: "<h2>Dashboard</h2><p>The first page you'll hit is your dashboard! This will list the lessons you have this week, as well as other summary information in the future.</p>"
                },{
                    element:'#classes-nav',
                    intro:"<p>Lets get started! Click here to create your first class.",
                    position:'right'
                }
            ]
          });
          intro.onbeforechange(function(targetElement) {
                   switch (targetElement.getAttribute("data-step"))
                   {
                       case "1":
                           $(".introjs-helperLayer").css("text-align", "center");

                       break;
                   }
               }).onexit(function() {
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
                 }).start();
      }
      if({{ \Illuminate\Support\Facades\Auth::user()->tutorial }} == 1) {
        startIntro();
      }
</script>
@endsection