@extends('templates.main', ['title' => 'Bruh'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="//unpkg.com/three"></script>
    <script src="//unpkg.com/three-globe"></script>
@endsection

@section('content')
    @include('shared.header')

    <main class="main">
        <h1 class="welcome">Specify your insurance case</h1>

        <form class="search" action="{{ \App\Providers\RouteServiceProvider::OFFERS }}">
            @csrf

            <input type="text" placeholder="Search.." name="q">

            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </form>

        <div class="stats-container">
            <div class="stats">
                <div class="stat">
                    <div class="title">Registered insurers</div>
                    <p class="counter">{{ $insurers_count }}</p>
                </div>

                <div class="stat">
                    <div class="title">Published offers</div>
                    <p class="counter">{{ $offers_count }}</p>
                </div>

                <div class="stat">
                    <div class="title">Insurance requests count</div>
                    <p class="counter">{{ $requests_count }}</p>
                </div>
            </div>
        </div>
    </main>

    <div id="globe"></div>

    <script>
        let rings = [];

        const colorInterpolator = t => `rgba(223,14,231,${1-t})`;

        const Globe = new ThreeGlobe()
            .globeImageUrl('//unpkg.com/three-globe/example/img/earth-dark.jpg')
            .bumpImageUrl('//unpkg.com/three-globe/example/img/earth-topology.png')
            .ringsData(rings)
            .ringColor(() => colorInterpolator)
            .ringMaxRadius('maxR')
            .ringPropagationSpeed('propagationSpeed')
            .ringRepeatPeriod('repeatPeriod');

        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('globe').appendChild(renderer.domElement);

        const scene = new THREE.Scene();
        scene.add(Globe);
        scene.add(new THREE.AmbientLight(0xbbbbbb));
        scene.add(new THREE.DirectionalLight(0xffffff, 0.6));

        const camera = new THREE.PerspectiveCamera();
        camera.aspect = window.innerWidth/window.innerHeight;
        camera.updateProjectionMatrix();
        camera.position.z = 500;

        (function animate() {
            Globe.rotation.y += 0.001;
            renderer.render(scene, camera);
            requestAnimationFrame(animate);
        })();

        window.addEventListener('resize', function () {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();

            renderer.setSize(window.innerWidth, window.innerHeight);
        }, false);

        fetch('/api/locations', {
            method: "GET",
        })
            .then(response => response.json())
            .then(data => {
                Globe.ringsData(
                    data.map(location => ({
                        lat: location["lat"],
                        lng: location["lng"],
                        maxR: 0.5 * 20 + 3,
                        propagationSpeed: 0.25 * 20 + 1,
                        repeatPeriod: 0.5 * 2000 + 200
                    }))
                );
            })
            .catch(err => {
                throw new Error(err);
            });
    </script>
@endsection


