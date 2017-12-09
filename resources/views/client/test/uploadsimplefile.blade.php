<h1>Upload simple file</h1>

<form action="{{route('test_uploadfile')}}" method="POST">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
    <input type="text" name="hoten" placeholder="Input your name..." />
    <br><br>
    <button type="submit">Upload</button>
</form>
