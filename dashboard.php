<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

/* ==============================
   DATA DASHBOARD
   ============================== */

// Total Produk
$query_produk = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM tbl_produk"
);
$produk = mysqli_fetch_assoc($query_produk);

// Total Pelanggan
$query_pelanggan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM tbl_pelanggan"
);
$pelanggan = mysqli_fetch_assoc($query_pelanggan);

// Total Transaksi
$query_transaksi = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM tbl_transaksi"
);
$transaksi = mysqli_fetch_assoc($query_transaksi);

// Total Penjualan
$query_penjualan = mysqli_query(
    $koneksi,
    "SELECT COALESCE(SUM(total_harga), 0) AS total
     FROM tbl_transaksi"
);
$penjualan = mysqli_fetch_assoc($query_penjualan);


/* ==============================
   TRANSAKSI TERBARU
   ============================== */

$query_terbaru = mysqli_query(
    $koneksi,
    "SELECT *
     FROM tbl_transaksi
     ORDER BY tanggal DESC
     LIMIT 5"
);


/* ==============================
   DATA GRAFIK 7 HARI
   ============================== */

$label_grafik = [];
$data_grafik = [];

for ($i = 6; $i >= 0; $i--) {

    $tanggal = date(
        'Y-m-d',
        strtotime("-$i days")
    );

    $query_grafik = mysqli_query(
        $koneksi,
        "SELECT COALESCE(SUM(total_harga), 0) AS total
         FROM tbl_transaksi
         WHERE DATE(tanggal) = '$tanggal'"
    );

    $hasil = mysqli_fetch_assoc($query_grafik);

    $label_grafik[] = date(
        'd M',
        strtotime($tanggal)
    );

    $data_grafik[] = (int) $hasil['total'];
}


/* ==============================
   DATA USER
   ============================== */

$nama_user = $_SESSION['nama'] ?? 'Admin';
$role_user = $_SESSION['role'] ?? 'admin';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - SellManage</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="dashboard">

    <!-- =================================
         SIDEBAR
         ================================= -->

    <aside class="sidebar">

        <!-- LOGO -->

        <div class="brand">

            <div class="brand-icon">
                S
            </div>

            <div class="brand-text">
                <h2>SellManage</h2>
                <span>Sistem Manajemen Penjualan</span>
            </div>

        </div>


        <!-- MENU -->

        <nav class="sidebar-menu">

            <a href="dashboard.php"
               class="sidebar-link active">

                <span class="icon">⌂</span>
                <span>Dashboard</span>

            </a>


            <a href="produk.php"
               class="sidebar-link">

                <span class="icon">▣</span>
                <span>Produk</span>

            </a>


            <a href="pelanggan.php"
               class="sidebar-link">

                <span class="icon">♟</span>
                <span>Pelanggan</span>

            </a>


            <a href="transaksi.php"
               class="sidebar-link">

                <span class="icon">▤</span>
                <span>Transaksi</span>

            </a>


            <a href="laporan.php"
               class="sidebar-link">

                <span class="icon">▥</span>
                <span>Laporan</span>

            </a>

        </nav>


        <!-- LOGOUT -->

        <div class="sidebar-logout">

            <a href="logout.php"
               class="logout-link">

                <span class="icon">↪</span>
                <span>Logout</span>

            </a>

        </div>

    </aside>


    <!-- =================================
         MAIN
         ================================= -->

    <main class="main">


        <!-- TOPBAR -->

        <header class="topbar">

            <div class="topbar-left">

                <div class="breadcrumb">
                    Dashboard
                </div>

                <h1>Dashboard</h1>

                <p>
                    Selamat datang, <?php echo htmlspecialchars($nama_user); ?>!
                </p>

            </div>


            <div class="topbar-right">

                <div class="user-avatar">

                    <?php
                    echo strtoupper(
                        substr($nama_user, 0, 1)
                    );
                    ?>

                </div>

                <div class="user-name">

                    <strong>
                        <?php
                        echo htmlspecialchars($nama_user);
                        ?>
                    </strong>

                    <span>
                        <?php
                        echo htmlspecialchars(
                            ucfirst($role_user)
                        );
                        ?>
                    </span>

                </div>

                <span class="arrow">
                    ▼
                </span>

            </div>

        </header>


        <!-- =================================
             STATISTIC CARDS
             ================================= -->

        <section class="stats">

            <!-- PRODUK -->

            <div class="stat-card card-blue">

                <div class="stat-icon">
                    📦
                </div>

                <div class="stat-info">

                    <span>
                        Total Produk
                    </span>

                    <strong>
                        <?php
                        echo number_format(
                            $produk['total']
                        );
                        ?>
                    </strong>

                </div>

            </div>


            <!-- PELANGGAN -->

            <div class="stat-card card-green">

                <div class="stat-icon">
                    👥
                </div>

                <div class="stat-info">

                    <span>
                        Total Pelanggan
                    </span>

                    <strong>
                        <?php
                        echo number_format(
                            $pelanggan['total']
                        );
                        ?>
                    </strong>

                </div>

            </div>


            <!-- TRANSAKSI -->

            <div class="stat-card card-orange">

                <div class="stat-icon">
                    🛒
                </div>

                <div class="stat-info">

                    <span>
                        Total Transaksi
                    </span>

                    <strong>
                        <?php
                        echo number_format(
                            $transaksi['total']
                        );
                        ?>
                    </strong>

                </div>

            </div>


            <!-- PENJUALAN -->

            <div class="stat-card card-purple">

                <div class="stat-icon">
                    💰
                </div>

                <div class="stat-info">

                    <span>
                        Total Penjualan
                    </span>

                    <strong>

                        Rp <?php

                        echo number_format(
                            $penjualan['total'],
                            0,
                            ',',
                            '.'
                        );

                        ?>

                    </strong>

                </div>

            </div>

        </section>


        <!-- =================================
             GRAPH + TRANSACTIONS
             ================================= -->

        <section class="dashboard-content">


            <!-- GRAFIK -->

            <div class="dashboard-box chart-box">

                <div class="box-title">

                    <div>

                        <h2>
                            Grafik Penjualan
                        </h2>

                        <p>
                            Penjualan 7 Hari Terakhir
                        </p>

                    </div>

                </div>


                <div class="chart-area">

                    <canvas id="salesChart"></canvas>

                </div>

            </div>


            <!-- TRANSAKSI TERBARU -->

            <div class="dashboard-box transaction-box">

                <div class="box-title">

                    <div>

                        <h2>
                            Transaksi Terbaru
                        </h2>

                        <p>
                            Transaksi terakhir
                        </p>

                    </div>

                </div>


                <div class="transaction-table">

                    <table>

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Tanggal</th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php

                        $no = 1;

                        if (
                            mysqli_num_rows(
                                $query_terbaru
                            ) > 0
                        ):

                            while (
                                $d =
                                mysqli_fetch_assoc(
                                    $query_terbaru
                                )
                            ):

                        ?>

                            <tr>

                                <td>
                                    <?php echo $no++; ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $d['nama_pelanggan']
                                    );
                                    ?>
                                </td>

                                <td>

                                    Rp <?php

                                    echo number_format(
                                        $d['total_harga'],
                                        0,
                                        ',',
                                        '.'
                                    );

                                    ?>

                                </td>

                                <td>

                                    <?php

                                    echo date(
                                        'd-m-Y',
                                        strtotime(
                                            $d['tanggal']
                                        )
                                    );

                                    ?>

                                </td>

                            </tr>

                        <?php

                            endwhile;

                        else:

                        ?>

                            <tr>

                                <td colspan="4"
                                    class="empty">

                                    Belum ada transaksi

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>


                <div class="transaction-footer">

                    <a href="transaksi.php">

                        Lihat Semua →

                    </a>

                </div>

            </div>

        </section>


        <!-- FOOTER -->

        <footer class="footer">

            © <?php echo date('Y'); ?>
            SellManage - Sistem Manajemen Penjualan

        </footer>


    </main>

</div>


<!-- =================================
     DATA GRAFIK
     ================================= -->

<script>

const chartLabels = <?php
    echo json_encode($label_grafik);
?>;

const chartData = <?php
    echo json_encode($data_grafik);
?>;


/* =================================
   CANVAS GRAFIK
   ================================= */

const canvas =
    document.getElementById('salesChart');

const ctx =
    canvas.getContext('2d');


function drawChart() {

    const width =
        canvas.parentElement.clientWidth;

    const height =
        canvas.parentElement.clientHeight;

    canvas.width = width;
    canvas.height = height;


    ctx.clearRect(
        0,
        0,
        width,
        height
    );


    /* Nilai maksimal */

    let max =
        Math.max(...chartData);

    if (max === 0) {
        max = 100;
    }


    /* Padding */

    const paddingLeft = 40;
    const paddingRight = 15;
    const paddingTop = 20;
    const paddingBottom = 35;


    const chartWidth =
        width -
        paddingLeft -
        paddingRight;

    const chartHeight =
        height -
        paddingTop -
        paddingBottom;


    /* GRID */

    ctx.strokeStyle = '#e5e7eb';
    ctx.lineWidth = 1;


    for (let i = 0; i <= 4; i++) {

        const y =
            paddingTop +
            (chartHeight / 4) * i;

        ctx.beginPath();

        ctx.moveTo(
            paddingLeft,
            y
        );

        ctx.lineTo(
            width - paddingRight,
            y
        );

        ctx.stroke();

    }


    /* TITIK DATA */

    const points = [];


    chartData.forEach(
        (value, index) => {

            const x =
                paddingLeft +
                (
                    chartWidth /
                    (chartData.length - 1)
                ) *
                index;

            const y =
                paddingTop +
                chartHeight -
                (
                    value / max
                ) *
                chartHeight;

            points.push({
                x: x,
                y: y
            });

        }
    );


    /* AREA DI BAWAH GRAFIK */

    ctx.beginPath();

    ctx.moveTo(
        points[0].x,
        height - paddingBottom
    );

    points.forEach(
        point => {

            ctx.lineTo(
                point.x,
                point.y
            );

        }
    );

    ctx.lineTo(
        points[points.length - 1].x,
        height - paddingBottom
    );

    ctx.closePath();

    const gradient =
        ctx.createLinearGradient(
            0,
            paddingTop,
            0,
            height
        );

    gradient.addColorStop(
        0,
        'rgba(37, 99, 235, 0.20)'
    );

    gradient.addColorStop(
        1,
        'rgba(37, 99, 235, 0.01)'
    );

    ctx.fillStyle = gradient;

    ctx.fill();


    /* GARIS */

    ctx.beginPath();

    points.forEach(
        (point, index) => {

            if (index === 0) {

                ctx.moveTo(
                    point.x,
                    point.y
                );

            } else {

                ctx.lineTo(
                    point.x,
                    point.y
                );

            }

        }
    );

    ctx.strokeStyle = '#2563eb';

    ctx.lineWidth = 2.5;

    ctx.stroke();


    /* TITIK */

    points.forEach(
        point => {

            ctx.beginPath();

            ctx.arc(
                point.x,
                point.y,
                4,
                0,
                Math.PI * 2
            );

            ctx.fillStyle = '#ffffff';

            ctx.fill();

            ctx.strokeStyle =
                '#2563eb';

            ctx.lineWidth = 2;

            ctx.stroke();

        }
    );


    /* LABEL TANGGAL */

    ctx.fillStyle = '#64748b';

    ctx.font = '10px Arial';

    ctx.textAlign = 'center';


    chartLabels.forEach(
        (label, index) => {

            const x =
                points[index].x;

            ctx.fillText(
                label,
                x,
                height - 12
            );

        }
    );

}


drawChart();

window.addEventListener(
    'resize',
    drawChart
);

</script>

</body>
</html>