<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Browser Image</title>
    
    <style>
       .fileExplorer {
        width: 100%;
        display: flex;
        /* justify-content: space-between; */
    }
    img {
        width: auto;
        height: 200px;
        margin-left: 20px;
    }
    img:hover {
        cursor: pointer;
    }
    span {
        /* font-weight: bold; */
        margin-left: 20px;
    }
    </style>
</head>

<body>
    <div class="fileExplorer">
        @foreach ($fileNames as $file)
        <div class="child">
            <img src="{{ asset('/public/uploads/ckeditor/'.$file) }}" alt="img" title="{{ asset('/public/uploads/ckeditor/'.$file) }}" width="120" height="130">
            <br>
            <span>{{ $file }}</span>
        </div>
        @endforeach
        
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.19.1/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            var funcNum = <?php echo $_GET['CKEditorFuncNum'].';'; ?>
            $('.fileExplorer').on('click', 'img', function() {
                var fileUrl = $(this).attr('title');
                window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
                window.close();
            }).hover(function() {
                $(this).css('cursor', 'poiter')
            });
        });
    </script>
</html>
