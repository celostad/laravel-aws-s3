
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POC - AWS S3</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<body>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Houve alguns problemas com seu envio.
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

        <div style="margin-top:50px;"></div>
        <table style="margin:0 auto;border: 1px solid #eee;">
            <tr style="border: 1px solid #eee;font-weight: bolder;">
                <td style="border: 1px solid #eee;width:250px;">Nome</td>
                <td style="border: 1px solid #eee;width:100px;">Tipo</td>
                <td style="border: 1px solid #eee;width:150px">Tamanho</td>
                <td style="border: 1px solid #eee;width:100px">Ações</td>
            </tr>

            

            @if (!is_null($arrFiles))
                @foreach ($arrFiles as $key => $arquivo)

                @php
                    $strFile = $arquivo['strFile'];
                    $strTamanho = $arquivo['size'];
                    $strTipo = $arquivo['tipo'];

                    @$urlPathFile = 'https://'.env('AWS_BUCKET').'.s3.amazonaws.com/'.env('AWS_PREFIX').@$strFile;

                @endphp
                    
                    <tr>
                    <td style="border: 1px solid #eee;text-align: left;"><a href="{{@$urlPathFile}}" target="_blank">{{$strFile}}</a></td>
                    <td style="border: 1px solid #eee;">{{ $strTipo }}</td>
                    <td style="border: 1px solid #eee;">{{ $strTamanho }}</td>
                    <td style="border: 1px solid #eee;">
                        <form id="form_{{$key}}" action="{{route('excluir')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="key" id="key" value="{{ $strFile }}">
                            <button type="button" onclick="javascript: confirmaExclusao('{{$key}}')" style="background-color:revert">Delete</button>                
                        </form>
                    </td>
                @endforeach
            @else
                <tr style="text-align:center;">';
                    <td colspan="5">Não existem registros.</td>
                </tr>
            @endif          

            <tr style="border: 1px solid #eee;font-weight: bolder; text-align:center; height:110px;">
                <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <td colspan="3" style="border: 0px solid #eee;height:60px;text-align:right !important;">
                        <input type="file" id="files" name="image" style="display:inline;" />
                    </td>
                    <td colspan="2" style="height:60px;text-align:left;">
                        <input type="submit" style="display:inline;" value="Upload" />
                    </td>
                </form>
            </tr>

        </table>


    </div>
</body>
<script>
    function confirmaExclusao(value) {

        var frm = document.getElementById('form_' + value) || null;
        if (confirm('Confirma a exclusão do arquivo?')) {
            frm.submit();
        }
    }
</script>

</html>