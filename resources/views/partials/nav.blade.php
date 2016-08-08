<div class="responsive-button"><i class="fa fa-bars"></i></div>
  <nav>
    <div class="responsive-close-button"><i class="fa fa-close"></i></div>
    <img src="{{ asset('/images/nav-icon.png') }}" alt="Classistant Icon" class="small-logo"/>
    <div class="welcome"><b>Hello,</b>
        <br/> {{ \Illuminate\Support\Facades\Auth::user()->name }}
        <a href="{{ route('account.edit') }}" class="footer-link">View Account</a>

        </div>

    <ul>
        <li {{ (isset($dashboardLink)) ? 'class=active' : '' }}>
            <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard fa-3x"></i>
                <span class="nav-text">DASHBOARD</span></a>
        </li>

        <li {{ (isset($classesLink)) ? 'class=active' : '' }} id="classes-nav">
            <a href="{{ route('classes.dashboard') }}"><i class="fa fa-pencil fa-3x"></i>
                <span class="nav-text">CLASSES</span></a>
        </li>

        {{--<li {{ (isset($calendarLink)) ? 'class=active' : '' }}>--}}
            {{--<a href="{{ route('classes.dashboard') }}"><i class="fa fa-calendar fa-3x"></i></a>--}}
            {{--<span class="nav-text">CALENDAR</span>--}}
        {{--</li>--}}

        <li {{ (isset($searchLink)) ? 'class=active' : '' }}>
            <a href="{{ route('search') }}"><i class="fa fa-search fa-3x"></i>
            <span class="nav-text">SEARCH</span></a>
        </li>

    </ul>
    <footer style="position:absolute;left:5px; bottom:10px;">
        <a href="http://goo.gl/forms/1XXLZwEloD" class="footer-link">Report a Bug</a>
        <div class="logout"><a href="{{ route('logout') }}"><br/>Logout</a></div>
        <a href="http://danlevings.uk" class="created-by" style="font-size:12px;padding-top:60px;">Created by Dan Levings</a>
    </footer>
</nav>

<script>
    var navOpen = false;
    $('.responsive-button').on('click', function (){
        $('nav').css({
            left: '0%',
            opacity:'1'
        });
        navOpen = true;
    });
    $('.responsive-close-button').on('click', function() {
        if(navOpen) {
            $('nav').css({
                left: '-100%',
                opacity:'0'
            });
            navOpen = false;
        }
    })
</script>