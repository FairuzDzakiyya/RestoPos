<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Drawer</title>
    <script src="https://unpkg.com/flowbite@1.6.4/dist/flowbite.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white p-10">

    <h1 class="text-2xl font-bold mb-6">Test Drawer Modal</h1>

    <!-- Tombol buat buka drawer -->
    <button data-drawer-target="delete-drawer" data-drawer-show="delete-drawer"
        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">
        Buka Modal Delete
    </button>

    <!-- Drawer component -->
    <div id="delete-drawer" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform bg-gray-800 w-80 translate-x-full" tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
        <h5 id="drawer-label" class="inline-flex items-center mb-4 text-sm font-semibold text-gray-400 uppercase">
            <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 108 8 8 8 0 00-8-8zm1 12H9v-2h2zm0-4H9V6h2z"/></svg>
            Delete Item
        </h5>
        <p class="mb-6 text-sm text-gray-300">Yakin ingin menghapus item ini?</p>
        <div class="flex justify-between">
            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, hapus</button>
            <button data-drawer-hide="delete-drawer" class="border text-gray-300 px-4 py-2 rounded hover:bg-gray-700">Batal</button>
        </div>
    </div>

</body>
</html>
