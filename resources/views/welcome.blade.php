<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNStay - BookNStay Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-50">
        <a href="#" class="text-2xl font-bold flex items-center">
            <span class="text-blue-600">Book</span><span class="text-orange-500">N</span><span class="text-blue-600">Stay</span>
        </a>
        <div class="flex items-center gap-6">
            <a href="#" class="text-gray-700 hover:text-gray-900">Login</a>
            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Sign Up</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative bg-cover bg-center h-96 flex items-center justify-center text-center" style="background-image: url('https://source.unsplash.com/1600x900/?luxury-hotel');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center p-4 w-full">
            <h1 class="text-4xl font-bold text-white">Temukan Hotel Terbaik untuk Perjalananmu</h1>
            <div class="bg-white p-4 rounded-lg shadow-lg mt-4 w-full max-w-3xl flex flex-col gap-2">
                <input type="text" placeholder="Kota, hotel, atau destinasi" class="border rounded-lg px-3 py-2 w-full">
                <div class="flex gap-2">
                    <div class="border rounded-lg px-3 py-2 flex items-center gap-2 w-full">
                        <input type="date" class="w-1/2">
                        <span>|</span>
                        <input type="date" class="w-1/2">
                    </div>
                    <div class="relative w-1/3">
                        <button id="dropdownButton" class="border rounded-lg px-3 py-2 w-full text-left">Kamar & Tamu</button>
                        <div id="dropdownMenu" class="absolute left-0 mt-2 w-full bg-white shadow-lg rounded-lg p-3 hidden">
                            <label class="block mb-1">Jumlah Kamar:</label>
                            <input type="number" min="1" value="1" class="border rounded-lg px-3 py-2 w-full">
                            <label class="block mt-2 mb-1">Jumlah Orang:</label>
                            <input type="number" min="1" value="1" class="border rounded-lg px-3 py-2 w-full">
                        </div>
                    </div>
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 w-full">Cari</button>
            </div>
        </div>
    </header>

    <!-- Hotel List -->
    <section class="container mx-auto my-8 p-4">
        <h2 class="text-2xl font-semibold mb-4">Hotel Populer</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <template id="hotel-card-template">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="" alt="Hotel" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">Nama Hotel</h3>
                        <p class="text-gray-500">Lokasi Hotel</p>
                        <p class="flex items-center gap-1 text-yellow-500 mt-1">&#9733; 4.5/5</p>
                        <p class="text-blue-600 font-bold mt-2">Rp 500.000 / malam</p>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-3 w-full">Pesan Sekarang</button>
                    </div>
                </div>
            </template>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; 2025 BookNStay. Semua hak dilindungi.</p>
        <div class="flex justify-center gap-4 mt-2">
            <a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a>
            <a href="#" class="text-gray-400 hover:text-white">Bantuan</a>
            <a href="#" class="text-gray-400 hover:text-white">Hubungi Kami</a>
        </div>
    </footer>

    <script>
        document.getElementById("dropdownButton").addEventListener("click", function() {
            document.getElementById("dropdownMenu").classList.toggle("hidden");
        });

        document.addEventListener("click", function(event) {
            if (!event.target.closest("#dropdownButton") && !event.target.closest("#dropdownMenu")) {
                document.getElementById("dropdownMenu").classList.add("hidden");
            }
        });

        // Hotel List
        const hotelList = document.querySelector(".grid");
        const hotelData = [
            { name: "Grand Hotel", location: "Jakarta, Indonesia", image: "https://source.unsplash.com/400x300/?hotel" },
            { name: "Resort Paradise", location: "Bali, Indonesia", image: "https://source.unsplash.com/400x300/?resort" },
            { name: "Boutique Stay", location: "Bandung, Indonesia", image: "https://source.unsplash.com/400x300/?boutique-hotel" },
            { name: "Luxury Villa", location: "Yogyakarta, Indonesia", image: "https://source.unsplash.com/400x300/?villa" },
            { name: "City Lights Hotel", location: "Surabaya, Indonesia", image: "https://source.unsplash.com/400x300/?city-hotel" }
        ];

        hotelData.forEach(hotel => {
            const template = document.getElementById("hotel-card-template").content.cloneNode(true);
            template.querySelector("img").src = hotel.image;
            template.querySelector("h3").textContent = hotel.name;
            template.querySelector("p.text-gray-500").textContent = hotel.location;
            hotelList.appendChild(template);
        });
    </script>
</body>
</html>
