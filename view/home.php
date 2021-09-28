@extends("home2")
    @startSection('title')
        Başlok BO
    @endSection()
@startSection("content")
Lorem ipsum dolor sit amet, consectetur adipisicing elit. At et inventore magni non obcaecati omnis pariatur. Ab amet consequatur deleniti, eaque eum molestias non quo temporibus. Expedita laboriosam nobis repudiandae.
<p>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur distinctio dolores enim error facilis harum ipsam laboriosam minus mollitia neque nobis obcaecati omnis quam qui, quibusdam, quo quos totam.
</p>
@print_r(["de", "ne", "me"])
<tamam>
    asdas
</tamam>
<br>
@foreach(["ahmet", "mehmet", "cemal"] as $key => $value)
{{ $key }} => {{ $value }} <br>
@endforeach
@endSection()
@startSection('footer')
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur blanditiis culpa debitis, dolor doloremque doloribus eveniet exercitationem expedita facere iste nam similique tempora. Adipisci consequuntur corporis expedita hic labore reiciendis.
@endSection()
