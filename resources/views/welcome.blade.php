{{-- resources/views/home.blade.php --}}

<!doctype html>
<html lang="en">
<head>
    <!-- Meta tags and Bootstrap CSS -->
    <title>TES - Venturo Camp Tahap 2</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        td, th {
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="{{ route('show.report') }}" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <!-- Dynamically generate year options -->
                                    @for ($year = date('Y')-1; $year >= date('Y') - 2; $year--)
                                        <option value="{{ $year }}" @if ($year == $selectedYear) selected @endif>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>
                @isset($salesData)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <!-- Add headers for each month -->
                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'] as $month)
                                    <th>{{ $month }}</th>
                                @endforeach
                                <th>Total</th> <!-- Add header for yearly total -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through your sales data and display it here -->
                            @foreach ($salesData as $menuName => $menuData)
                                @if($menuName != 'Totals') {{-- Skip the Totals row here --}}
                                    <tr>
                                        <td>{{ $menuData['name'] }}</td>
                                        <!-- Add monthly sales data for each menu -->
                                        @foreach ($menuData['monthly_sales'] as $sales)
                                            <td>{{ number_format($sales, 0, ',', '.') }}</td>
                                        @endforeach
                                        <td><strong>{{ number_format($menuData['yearly_total'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!-- Totals row -->
                            <tr>
                                <td><strong>{{ $salesData['Totals']['name'] }}</strong></td>
                                @foreach ($salesData['Totals']['monthly_sales'] as $total)
                                    <td><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                                @endforeach
                                <td><strong>{{ number_format($salesData['Totals']['yearly_total'], 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                @endisset
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
