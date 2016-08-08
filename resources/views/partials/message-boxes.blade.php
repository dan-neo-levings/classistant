<style>

/* MESSAGE BOXES */
.error-box, .success-box, .warning-box, .information-box {
  position: fixed;
  top: -120px;
  left: 50%;
  transform: translateX(-50%);
  width: 400px;
  font-size: 13px;
  padding: 13px;
  color: white;
  background: #ff1d25;
  opacity: 0;
  z-index:1200;
  transition: 0.5s all;
  text-align:center;
}
.error-box.show, .success-box.show, .warning-box.show, .information-box.show {
  top: 20px;
  opacity: 1;
}
.success-box {
  background: #2ecc71;
}
.warning-box {
  background: #e67e22;
}
.information-box {
  background: #3498db;
}
</style>

    <div class="error-box">
            Shit!
        </div>

        <div class="warning-box">
            Shit!
        </div>

        <div class="success-box">
            Shit!
        </div>

        <div class="information-box">
            Shit!
        </div>

<script>
    function showErrorBox(msg) {
        $('.error-box').html(msg);
        $('.error-box').addClass("show");
        setTimeout(hideErrorBox, 5000);
    }
    function hideErrorBox() {
        $('.error-box').removeClass("show");
    }

    function showWarningBox(msg) {
        $('.warning-box').html(msg);
        $('.warning-box').addClass("show");
        setTimeout(hideWarningBox, 5000);
    }
    function hideWarningBox() {
        $('.warning-box').removeClass("show");
    }

    function showSuccessBox(msg) {
        $('.success-box').html(msg);
        $('.success-box').addClass("show");
        setTimeout(hideSuccessBox, 5000);
    }
    function hideSuccessBox() {
        $('.success-box').removeClass("show");
    }

    function showInformationBox(msg) {
        $('.information-box').html(msg);
        $('.information-box').addClass("show");
        setTimeout(hideInformationBox, 5000);
    }
    function hideInformationBox() {
        $('.information-box').removeClass("show");
    }
    </script>

    @if (session('error'))
        <script>
            showErrorBox("{{ session('error') }}");
        </script>
    @endif
    @if ($errors->count() > 0)
        <script>
            showErrorBox("<B>There are {{$errors->count()}} errors!</b><br /> @foreach($errors->all() as $error) {{ $error }}<BR /> @endforeach");
        </script>
    @endif

    @if (session('warning'))
        <script>
            showWarningBox("{{ session('warning') }}");
        </script>
    @endif

    @if (session('success'))
        <script>
            showSuccessBox("{{ session('success') }}");
        </script>
    @endif

    @if (session('information'))
        <script>
            showInformationBox("{{ session('information') }}");
        </script>
    @endif



