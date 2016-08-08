@extends('app')

@section('main')
<style>

</style>
<section class="sidebar">

    <h1>Search</h1>

    @if(isset($finalResult))
        @if(count($finalResult) > 0)
            @foreach($finalResult as $subject => $result)
                @foreach($result as $lesson)
                    <div class="class-box search-box">
                        <div class="class-name-container search">
                            <div class="search-unit"><?= str_replace('_', ' ', $subject) ?></div>
                            <div class="written-by">Written By: <?= str_replace('_', ' ',$lesson->teacher ) ?></div>
                        </div>
                        <div class="inner-class-box">

                        <a href="{{ route('lesson.generateDoc', ['id' => $lesson->id]) }}">
                            <div class="search-lesson-box" data-topic-id="topic">
                                <?= ($lesson->topic != null) ? $lesson->topic : "No Title Set" ?>
                                <div class="search-class"><?= ($lesson->name != null) ? $lesson->name : "No Class Assigned" ?> </div>
                                <div class="search-date"><?= $lesson->date?></div>
                            </div>
                        </a>
                        <a href="{{ route('lesson.createFromId', ['id' => $lesson->id]) }}">
                            <div class="search-add"><i class="fa fa-plus"></i></div>
                        </a>

                        </div>
                        <i class="fa fa-angle-down class-box-switch search-box-switch"></i>
                    </div>
                @endforeach
            @endforeach
        @else
            No results :(
        @endif
    @else
        Please type a term into the search bar
    @endif

</section>

<section class="sidebar search-sidebar">
    <h1>General Search</h1>
    <form action="{{ route('search.term') }}" method="POST">
        {{ csrf_field() }}
         <input type="text" name="term" id="search-bar" placeholder="Search Terms..." value="{{ $previousSearch['term'] or "" }}"/>
         <input type="submit" class="standard-button">
    </form>

    <h1>Advanced Search</h1>
    <form action="{{ route('search.term.filtered') }}" method="POST">
        {{ csrf_field() }}

         <label for="unit">Unit:</label>
         <input type="text" name="unit" id="unit" placeholder="Unit 1: Communication" value="{{ $previousSearch['unit'] or "" }}"/>

         <label for="teacher">Teacher:</label>
         <input type="text" name="teacher" id="teacher" placeholder="John Doe" value="{{ $previousSearch['teacher'] or "" }}"/>

         <label for="topic">Topic:</label>
         <input type="text" name="topic" id="topic" placeholder="Creating a CV" value="{{ $previousSearch['topic'] or "" }}"/>

         <label for="class">Class:</label>
         <input type="text" name="class" id="class" placeholder="BTEC L3" value="{{ $previousSearch['class'] or "" }}"/>

         <input type="submit" class="standard-button">
    </form>
    {{--<h1>Advanced Search</h1>--}}
    {{--<p>Search by Date</p>--}}
    {{--<p>Search by Teacher</p>--}}
    {{--<p>Search by Unit</p>--}}
    {{--<p>Search by Lesson Name</p>--}}
</section>

@endsection

@section('extra-scripts')
<script>
$('.class-name-container').on('click', function(e) {
    var parent = $(this).parent();
    var inner = $(this).next();

    if(parent.hasClass("open")) {
        parent.removeClass("open");
        parent.height("60px");
    } else {
        parent.addClass("open");
        parent.height($(inner).height() + 85 + "px");
    }

});
</script>

@endsection
