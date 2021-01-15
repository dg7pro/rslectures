<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    {{--<link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">--}}

    <title>Dynamic Image Slider using bxslider</title>

    {{--<style type="text/css">
        .slider{
            height: 300px;
            border: 1px solid red;
            margin-top: 20px;
        }
    </style>--}}
</head>
<body>
<div class="container">


    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
            <h1>Dynamic Image Slider using bxSlider</h1>
            <h3>Part 1: Upload Image in php and mysql</h3>
            <hr>
            <form name="uploadFrm" method="post" action="{{'upload-image'}}" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="file">Select file:</label><br>
                    <input type="file" name="file" id="file">
                    <p class="help-block">Select your file which you want to upload.</p>
                </div>
                <div class="footer">
                    <button type="submit" name="submit" class="btn btn-primary">Upload</button>

                </div>
            </form>
            <hr>
        </div>

    </div>


    <div class="row mt-3">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                @foreach($pics as $pic)
                    <div class="col-xs-6 col-md-3">
                        <a href="javascript:selectImage('{{$pic['name']}}')">
                            <img src="{{'/media/'.$pic['name']}}" alt="no image" width="200px" class="rounded mx-auto img-thumbnail">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>









<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

{{--<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script>
    $(document).ready(function(){
        $('.slider').bxSlider({
            pager:false,
            slideWidth: 600,
            slideHeight:500
        });
    });
</script>--}}

<script type="text/javascript">
    var CKEditorFuncNum = "{{ $_REQUEST['CKEditorFuncNum'] }}";
    var url = "{{'http://'.$_SERVER['SERVER_NAME'].'/media/' }}"
    function selectImage(imgName){
        url +=imgName;
        console.log(url);
        window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, url);
        window.close();
    }
</script>


</body>
</html>
