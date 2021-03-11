<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>R.S. Lectures</title>

</head>
<body>

{{--<iframe src ="{{'/uploads/demo_lesson_1.pdf'}}" width="100%" height="700px" style="border: none"></iframe>--}}

{{--<object data="{{'/uploads/'.$pdf}}" type="application/pdf" width="100%" height="700px">
    Example fallback content: This browser does not support PDFs. Please download the PDF to view it: Download PDF.
</object>--}}

<embed id="my_pdf" src="{{'/uploads/'.$pdf.'#toolbar=0'}}" type="application/pdf">

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script>
    ht = $(window).height();
    wt = $(window).width();
    document.getElementById("my_pdf").width = wt;
    document.getElementById("my_pdf").height = ht;
</script>

</body>
</html>