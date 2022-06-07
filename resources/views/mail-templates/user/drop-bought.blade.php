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
                        <h1>Congratulations. Your NFTS has been successfully sold in our system: @if($drop && $drop->name) {{$drop->name}} @endif</h1>
                    </td>
                </tr>

                <tr>
                    <td align="center">
                        <table class="textbutton" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                @if($nfts && count($nfts))
                                    <p>Details:</p>
                                    @foreach($nfts as $nft)
                                        @if($nft->metadata->name) <p>Name NFT - {{$nft->metadata->name}}</p>@endif
                                    @endforeach

                                    <br>
                                    <p>The amount of the deal is -  {{ $nfts[0]->price * count($nfts) }}</p>
                                @endif
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
