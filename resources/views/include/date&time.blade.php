@php
    date_default_timezone_set('Asia/Jakarta');
    $getDay = date('l');
    $getDate = date('d-m-Y');
    // $getTime = date('h:i A');
    // $getTime = date('h:i a');
@endphp

<div class="wadah_Waktu mb-4 p-2 border-bottom">
    <div>
        Date & Time :
    </div>
    {{$getDay.', '.$getDate}}
    {{-- <label id="currentDate"></label> --}}
    <label id="currentTime"></label>
</div>

{{-- script untuk date time nya --}}
<script>
    function printTime() {
        var d = new Date();
        var date = d.getDate();
        var month = d.getMonth();
        var year = d.getFullYear();
        var hours = d.getHours();
        var mins = d.getMinutes();
        var secs = d.getSeconds();

        // document.getElementById("currentDate").innerHTML =
        // (("0"+date).slice(-2)) +" - "+
        // (("0"+(month+1)).slice(-2)) +" - "+
        // (year);

        document.getElementById("currentTime").innerHTML =
        ("("+("0"+hours).slice(-2)) +":"+
        (("0"+mins).slice(-2)) +":"+
        (("0"+secs).slice(-2)+")");
    }
    setInterval(printTime, 1000); // 1000 ms = 1 s
</script>
