@extends('mail-templates.layout.layout')

@section('content')
    <tr>
        <td bgcolor="#FFFFFF" style="border-bottom-left-radius: 4px;border-bottom-right-radius: 4px;"
            align="center">
            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="40"></td>
                </tr>
                <!-- message and button -->
                <tr>
                    <td align="center">
                        <h1>Congratulations! Your NFT has been successfully sold on our marketplace.</h1>
                    </td>
                </tr>

                <tr>
                    <td align="center">
                        <table class="textbutton" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <p>Details:</p>
                                @if($nft->metadata->name) <p>Name NFT - {{$nft->metadata->name}}</p>@endif
                                @if($nft->price) <p>The amount of the deal is - {{$nft->price}}</p>@endif
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- message and button -->
                <tr>
                    <td height="25"></td>
                </tr>

                <!-- preference -->
                <tr>
                    <td align="center" style="font-size:13px; color:#7f8c8d;">
                        <a href="{{ env('APP_URL') }}" target="_blank">Beatoken</a>
                    </td>
                </tr>
                <!-- end preference -->
                <tr>
                    <td height="30"></td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
