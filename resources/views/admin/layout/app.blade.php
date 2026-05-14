<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Online Course')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ URL::asset('admin/img/favicon.ico') }}" rel="icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .chart-bar {
            transition: height 1s ease-in-out;
        }
    </style>
    @stack('css')
</head>

<body class="bg-slate-50 text-slate-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin/layout/partial/sidebar')
        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @yield('header', view('admin.layout.partial.header'))
            @yield('content')

        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function sweet(status, message) {
            Swal.fire({
                toast: true,
                position: 'top-end', // Top-right
                icon: status === "success" ? 'success' : 'error',
                title: message,
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
    </script>
    @if (session('success'))
        <script>
            sweet("success", "{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            sweet("error", "{{ session('error') }}");
        </script>
    @endif

    <script>
   
    </script>
    <script>
        function confirmDelete(action) {
            // console.log(action);
            
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(action, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": token
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        sweet('success', data.message);
                        location.reload();
                    } else {
                        sweet('error', data.message);
                    }
                })
                .catch(error => {
                    sweet('error', error);
                });
        }
    </script>
    @stack('script')
</body>

</html>
