
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POC - AWS S3</title>

    <!-- Fonts -->
    <link href="{{ asset('css/aws.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
                <td class="row_files_bd w250">Nome</td>
                <td class="row_files_bd w100">Tipo</td>
                <td class="row_files_bd w150">Tamanho</td>
                <td class="row_files_bd w100">Ações</td>
            </tr>

            

            @if (!is_null($arrFiles))
                @foreach ($arrFiles as $key => $arquivo)

                @php
                    $strFile = $arquivo['strFile'];
                    $strTamanho = $arquivo['size'];
                    $strTipo = $arquivo['tipo'];

                    @$urlPathFile = 'https://'.env('AWS_BUCKET').'.s3.amazonaws.com/'.env('AWS_PREFIX').@$strFile;

                @endphp
                    
                    <tr class="h30">
                    <td class="row_files_bd left"><a href="{{@$urlPathFile}}" target="_blank">{{$strFile}}</a></td>
                    <td class="row_files_bd">{{ $strTipo }}</td>
                    <td class="row_files_bd">{{ $strTamanho }}</td>
                    <td class="row_files_bd">
                        <form id="form_{{$key}}" action="{{route('excluir')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="key" id="key" value="{{ $strFile }}">
                            <button type="button" onclick="javascript: confirmaExclusao('{{$key}}')" class="btn_delete" style="background-color:revert">Delete</button>                
                        </form>
                    </td>
                @endforeach
            @else
                <tr class="center">
                    <td colspan="5"><span style="color:red;"> Não há registros.</span></td>
                </tr>
            @endif          

            <tr class="upload row_files_bd">
                <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <td colspan="3" class="row_files" style="height:60px;text-align:right !important;">
                        <input type="file" id="files" name="image" style="display:inline;" />
                    </td>
                    <td colspan="2" class="left" style="height:60px;">
                        <input type="submit" class="btn_upload" style="display:inline;" value="Upload" />
                    </td>
                </form>
            </tr>

        </table>
    </div>
    
<script src="{{ asset('js/aws.js') }}"></script>

</body>
</html>