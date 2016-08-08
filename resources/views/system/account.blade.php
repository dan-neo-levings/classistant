@extends('app')

@section('main')
<section class="sidebar">



    <h1>Your Account</h1>
    <p>You're able to change your account details here.</p>
    <h2>Tutorial</h2>
    <p>Need a hand? Click the button below to re-enable the tutorial. </p>
        <button id="enable-tutorial">Re-enable tutorial</button>
    <h1>Department</h1>
    <form action="{{ route('account.changeDepartment') }}" method="POST">
    {{ csrf_field() }}
        <p>Your department allows us to create suggested data more personalised towards you and your classes.</p>
        <p>Currently, your department is set to: <b>{{ \Illuminate\Support\Facades\Auth::user()->department }}</b></p>

        <label for="department">Department:</label>
        <select name="department">
            <option value="0">Please select a department...</option>
            <option>Computing</option>
            <option>Hair and Beauty</option>
            <option>Other</option>
        </select>

        <input type="submit" value="Change Department" class="save-button"/>
    </form>


</section>

<section class="sidebar">
    <h1>Account Expiration</h1>

    <p>Your account expires in: <b>{{ \Illuminate\Support\Facades\Auth::user()->expiration->diffForHumans() }}</b><button style="float:right">Renew</button></p>

    <h1>Change my Password</h1>
    <form action="{{ route('account.changePassword') }}" method="POST">
    {{ csrf_field() }}
         <label for="old-password">Old Password:</label>
        <input type="password" name="old-password" />


        <label for="password">New Password:</label>
        <input type="password" name="password"/>

        <label for="password_confirmation">Repeat new password:</label>
        <input type="password" name="password_confirmation" />

        <input type="submit" value="Change Password" class="save-button"/>
    </form>
</section>

@endsection

@section('extra-scripts')
    <script>
        $('#enable-tutorial').on('click', function() {
             $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });

            $.ajax({
                type:'POST',
                url:'{{ route('account.enableTutorial') }}',
                success:function(res) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            })
        })
    </script>
@endsection