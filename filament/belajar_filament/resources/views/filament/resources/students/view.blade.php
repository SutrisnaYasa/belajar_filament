<x-filament-panels::page>
    @if ($this->hasInfolist())
        {{ $this->infolist }}
        <div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
    @else
        {{ $this->form }}
    @endif
</x-filament-panels::page>

<script src="{{ asset('qrcode.js') }}"></script>
<script>
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width : 100,
        height : 100
    });

    function makeCode () {
        var elText = "halooo";

        qrcode.makeCode(elText);
    }

    makeCode();
</script>
