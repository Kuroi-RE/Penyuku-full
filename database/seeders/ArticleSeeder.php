<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a penangkaran user (atau buat jika belum ada)
        $penangkaran = User::where('role', 'penangkaran')->first();
        
        if (!$penangkaran) {
            $penangkaran = User::create([
                'name' => 'Admin Penangkaran',
                'username' => 'adminpenangkaran',
                'email' => 'admin@penangkaran.com',
                'password' => bcrypt('password'),
                'role' => 'penangkaran'
            ]);
        }

        $articles = [
            [
                'title' => 'Pelepasan 500 Tukik Penyu Hijau ke Laut Lepas',
                'category' => 'Kegiatan',
                'excerpt' => 'Pelepasan 500 tukik penyu hijau hasil penetasan dari Penangkaran Penyu Cilacap ke laut lepas sebagai upaya konservasi.',
                'content' => "Pada tanggal 1 November 2025, Penangkaran Penyu Cilacap berhasil melakukan pelepasan 500 tukik penyu hijau (Chelonia mydas) ke laut lepas. Kegiatan ini merupakan bagian dari program konservasi penyu yang telah berjalan sejak tahun 2010.\n\nTukik-tukik ini merupakan hasil penetasan dari telur-telur penyu yang dikumpulkan oleh tim relawan kami selama musim bertelur. Setelah melalui proses inkubasi dan perawatan intensif selama beberapa minggu, tukik-tukik ini telah siap untuk dikembalikan ke habitat alaminya.\n\nKegiatan pelepasan ini dihadiri oleh masyarakat setempat, pelajar, dan para relawan. Ini merupakan momen edukasi yang sangat penting untuk meningkatkan kesadaran masyarakat tentang pentingnya konservasi penyu.\n\nPenyu hijau merupakan salah satu dari tujuh spesies penyu yang ada di dunia dan saat ini statusnya terancam punah. Pelepasan tukik ke laut lepas adalah salah satu upaya nyata untuk menjaga kelangsungan populasi penyu hijau di Indonesia.",
                'status' => 'published',
                'views' => 245
            ],
            [
                'title' => 'Workshop Konservasi Penyu untuk Generasi Muda',
                'category' => 'Edukasi',
                'excerpt' => 'Kegiatan edukasi dan workshop tentang pentingnya konservasi penyu bagi generasi muda dan pelajar di Cilacap.',
                'content' => "Workshop konservasi penyu yang diadakan pada 28 Oktober 2025 berhasil menarik perhatian lebih dari 100 pelajar SMA se-Cilacap. Workshop ini bertujuan untuk memberikan pemahaman mendalam tentang ekologi penyu, ancaman yang mereka hadapi, dan bagaimana kita bisa berkontribusi dalam upaya konservasi.\n\nMateri workshop meliputi:\n- Biologi dan siklus hidup penyu\n- Ancaman terhadap populasi penyu (polusi plastik, perburuan, kerusakan habitat)\n- Teknik monitoring dan perlindungan sarang penyu\n- Cara melaporkan temuan penyu yang terluka atau bertelur\n\nPeserta workshop juga berkesempatan untuk melihat langsung fasilitas penangkaran dan berinteraksi dengan tukik-tukik yang sedang dalam perawatan. Antusiasme para pelajar sangat tinggi, banyak yang menyatakan keinginannya untuk bergabung menjadi relawan konservasi penyu.\n\nWorkshop seperti ini sangat penting karena generasi muda adalah kunci keberhasilan konservasi jangka panjang. Dengan menanamkan kesadaran lingkungan sejak dini, kita berharap dapat menciptakan generasi yang peduli dan aktif dalam melindungi satwa laut.",
                'status' => 'published',
                'views' => 178
            ],
            [
                'title' => 'Patroli Pantai Malam: Mencari dan Melindungi Penyu Bertelur',
                'category' => 'Kegiatan',
                'excerpt' => 'Tim relawan melakukan patroli malam untuk menemukan dan melindungi penyu yang bertelur di pantai Cilacap.',
                'content' => "Patroli pantai malam adalah salah satu kegiatan rutin yang dilakukan oleh tim relawan Penangkaran Penyu Cilacap. Kegiatan ini dilakukan setiap malam selama musim bertelur (biasanya Maret-Oktober) untuk mencari penyu yang naik ke pantai untuk bertelur.\n\nPada malam tanggal 25 Oktober 2025, tim kami berhasil menemukan 3 ekor penyu hijau yang sedang bertelur di sepanjang pantai. Proses bertelur penyu biasanya berlangsung selama 1-2 jam, dimana induk penyu menggali lubang di pasir dan meletakkan 80-120 butir telur.\n\nTugas tim relawan adalah:\n1. Memantau proses bertelur tanpa mengganggu induk penyu\n2. Mencatat data biometrik (ukuran, berat, kondisi kesehatan)\n3. Mengamankan telur dari predator dan pemburu\n4. Memindahkan telur ke hatchery untuk inkubasi yang aman\n\nDari tiga sarang yang ditemukan malam itu, kami berhasil mengamankan total 287 butir telur. Telur-telur ini kemudian akan diinkubasi di hatchery kami selama 45-60 hari hingga menetas.\n\nPatroli pantai malam adalah pekerjaan yang menantang tetapi sangat penting. Tanpa upaya ini, banyak sarang penyu akan diambil oleh pemburu atau dimakan predator alami seperti biawak dan anjing liar.",
                'status' => 'published',
                'views' => 312
            ],
            [
                'title' => 'Fakta Menarik: 7 Spesies Penyu di Dunia',
                'category' => 'Edukasi',
                'excerpt' => 'Mengenal 7 spesies penyu yang ada di dunia dan status konservasinya saat ini.',
                'content' => "Tahukah Anda bahwa hanya ada 7 spesies penyu yang masih hidup di dunia saat ini? Mari kita kenali mereka:\n\n1. Penyu Hijau (Chelonia mydas)\nStatus: Terancam Punah\nCiri khas: Cangkang berwarna hijau kecoklatan, herbivora, dapat tumbuh hingga 150 cm.\n\n2. Penyu Sisik (Eretmochelys imbricata)\nStatus: Sangat Terancam Punah\nCiri khas: Cangkang berwarna-warni, paruh berbentuk seperti burung elang.\n\n3. Penyu Tempayan (Caretta caretta)\nStatus: Rentan\nCiri khas: Kepala besar, rahang kuat untuk memakan kerang dan kepiting.\n\n4. Penyu Lekang (Lepidochelys olivacea)\nStatus: Rentan\nCiri khas: Ukuran kecil, cangkang berbentuk hati, sering bertelur secara massal (arribada).\n\n5. Penyu Kempi (Lepidochelys kempii)\nStatus: Sangat Terancam Punah\nCiri khas: Spesies terkecil, hanya ditemukan di Teluk Meksiko dan Atlantik.\n\n6. Penyu Belimbing (Dermochelys coriacea)\nStatus: Sangat Terancam Punah\nCiri khas: Terbesar dari semua penyu, tidak memiliki cangkang keras, dapat menyelam hingga 1.200 meter.\n\n7. Penyu Pipih (Natator depressus)\nStatus: Data Kurang\nCiri khas: Hanya ditemukan di perairan Australia, cangkang pipih.\n\nDi Indonesia, kita dapat menemukan 6 dari 7 spesies ini (kecuali Penyu Kempi). Sayangnya, semua spesies penyu menghadapi ancaman serius seperti polusi plastik, perburuan, tangkapan sampingan nelayan, dan kerusakan habitat pantai.\n\nUpaya konservasi seperti yang dilakukan Penangkaran Penyu Cilacap sangat penting untuk memastikan bahwa generasi mendatang masih bisa melihat makhluk purba yang luar biasa ini.",
                'status' => 'published',
                'views' => 421
            ],
            [
                'title' => 'Pembersihan Pantai Bersama Komunitas',
                'category' => 'Kegiatan',
                'excerpt' => 'Aksi bersih pantai untuk menjaga habitat penyu tetap bersih dari sampah plastik dan polusi.',
                'content' => "Pada tanggal 15 Oktober 2025, Penangkaran Penyu Cilacap bersama dengan komunitas lokal mengadakan aksi pembersihan pantai yang diikuti oleh lebih dari 200 relawan dari berbagai kalangan.\n\nSampah plastik adalah salah satu ancaman terbesar bagi penyu laut. Penyu sering kali menganggap kantong plastik sebagai ubur-ubur (makanan favorit mereka) dan memakannya, yang dapat menyebabkan kematian karena penyumbatan saluran pencernaan.\n\nHasil pembersihan hari itu:\n- 450 kg sampah plastik\n- 180 kg sampah organik\n- 75 kg sampah logam dan kaca\n- Total 705 kg sampah berhasil dikumpulkan\n\nSelain membersihkan pantai, acara ini juga menjadi ajang edukasi tentang dampak sampah plastik terhadap ekosistem laut dan pentingnya mengurangi penggunaan plastik sekali pakai.\n\nBeberapa tips mengurangi sampah plastik:\n- Gunakan tas belanja kain yang dapat digunakan berulang kali\n- Hindari sedotan plastik, bawa sedotan stainless steel sendiri\n- Gunakan botol minum isi ulang\n- Tolak kantong plastik, bawa wadah sendiri saat belanja\n- Pilih produk dengan kemasan minimal\n\nAksi pembersihan pantai seperti ini akan terus kami lakukan secara rutin setiap bulan. Mari bergabung dan menjadi bagian dari solusi untuk laut yang lebih bersih!",
                'status' => 'published',
                'views' => 289
            ],
            [
                'title' => 'Ancaman Terbesar Bagi Penyu Laut di Era Modern',
                'category' => 'Edukasi',
                'excerpt' => 'Memahami berbagai ancaman yang dihadapi penyu laut di era modern dan bagaimana kita bisa membantu.',
                'content' => "Penyu telah ada di bumi selama lebih dari 100 juta tahun, bertahan melalui berbagai perubahan iklim dan bencana alam termasuk kepunahan dinosaurus. Namun, dalam 50 tahun terakhir, populasi penyu mengalami penurunan drastis akibat aktivitas manusia.\n\nAncaman Utama Bagi Penyu:\n\n1. Polusi Plastik\nSetiap tahun, 8 juta ton plastik masuk ke laut. Penyu sering memakan plastik yang mengapung, mengira itu adalah ubur-ubur. Plastik yang tertelan dapat menyebabkan penyumbatan saluran pencernaan dan kematian.\n\n2. Tangkapan Sampingan (Bycatch)\nRibuan penyu terjebak dan mati setiap tahunnya dalam jaring ikan dan perangkap nelayan. Penyu perlu ke permukaan untuk bernapas, jika terjebak terlalu lama mereka akan tenggelam.\n\n3. Perburuan dan Perdagangan Ilegal\nMeskipun dilindungi undang-undang, penyu masih diburu untuk diambil daging, telur, cangkang, dan kulitnya.\n\n4. Kerusakan Habitat Pantai\nPembangunan hotel, resort, dan infrastruktur di pantai mengurangi area bertelur penyu. Cahaya buatan juga membingungkan tukik yang baru menetas.\n\n5. Perubahan Iklim\nKenaikan suhu pasir mempengaruhi rasio jenis kelamin tukik yang menetas. Suhu lebih tinggi menghasilkan lebih banyak betina, yang dapat mengganggu keseimbangan populasi.\n\n6. Predator yang Diperkenalkan Manusia\nAnjing, kucing, dan hewan peliharaan lain yang dibawa manusia sering memangsa telur dan tukik penyu.\n\nApa yang Bisa Kita Lakukan?\n- Kurangi penggunaan plastik sekali pakai\n- Dukung produk seafood yang berkelanjutan\n- Jangan beli produk dari cangkang penyu\n- Matikan lampu pantai saat malam hari\n- Laporkan temuan penyu yang terluka atau bertelur\n- Dukung organisasi konservasi penyu\n\nSetiap tindakan kecil kita dapat membuat perbedaan besar bagi kelangsungan hidup penyu laut!",
                'status' => 'published',
                'views' => 356
            ]
        ];

        foreach ($articles as $article) {
            Article::create(array_merge($article, ['user_id' => $penangkaran->id]));
        }
    }
}

