<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo $laporan_perkembangan; ?></h3>
                <p>Laporan Perkembangan (Bulan Ini)</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php echo $laporan_pakan; ?></h3>
                <p>Laporan Produksi Pakan (Bulan Ini)</p>
            </div>
            <div class="icon"><i class="fas fa-seedling"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php echo $total_ib; ?></h3>
                <p>Inseminasi Buatan (Bulan Ini)</p>
            </div>
            <div class="icon"><i class="fas fa-venus-mars"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?php echo $total_kelompok; ?></h3>
                <p>Total Kelompok Ternak</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="<?php echo site_url('perkembangan/kelompok'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?php echo $total_hewan; ?></h3>
                <p>Total Hewan Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-paw"></i></div>
            <a href="<?php echo site_url('master/hewan'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Grafik Produksi Pakan (6 Bulan Terakhir)</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="pakanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/admin_template/adminlte/plugins/chart.js/Chart.min.js'); ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('pakanChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $chart_labels; ?>,
            datasets: [{
                label: 'Total Produksi (KG)',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: <?php echo $chart_values; ?>
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                xAxes: [{
                    gridLines: { display: false, }
                }],
                yAxes: [{
                    ticks: { beginAtZero: true },
                    gridLines: { display: true, }
                }]
            }
        }
    });
});
</script>