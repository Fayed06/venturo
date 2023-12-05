<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesReportController extends Controller
{
    public function showReport(Request $request)
    {
        $year = $request->input('tahun');
        $salesData = null;

        if ($year) {
            // Initialize Guzzle HTTP client
            $client = new Client();

            // Use Guzzle to send a GET request to the 'menu' endpoint
            $menuResponse = $client->request('GET', 'http://tes-web.landa.id/intermediate/menu');
            // Parse the response body to JSON
            $menus = json_decode($menuResponse->getBody(), true);

            // Use Guzzle to send a GET request to the 'transaksi' endpoint with the year query parameter
            $transaksiResponse = $client->request('GET', "http://tes-web.landa.id/intermediate/transaksi", [
                'query' => ['tahun' => $year]
            ]);
            // Parse the response body to JSON
            $transaksi = json_decode($transaksiResponse->getBody(), true);

            // Process this data to generate $salesData
            $salesData = $this->processDataForTable($menus, $transaksi, $year);
        }

        // Render the 'welcome' view (or 'home' if that's your intended view) with the sales data and selected year
        return view('welcome', [
            'salesData' => $salesData,
            'selectedYear' => $year
        ]);
    }

    private function processDataForTable($menus, $transaksi, $year)
    {
        // Initialize the structure for the sales data.
        $dataForTable = [];
        $monthlyTotals = array_fill(1, 12, 0); // Holds the total for each month
        $yearlyTotal = 0; // Holds the grand total for the year

    // Prepare the structure for each menu item.
    foreach ($menus as $menu) {
        $menuName = $menu['menu']; // Assuming 'menu' is unique and can be used as an ID.
        $dataForTable[$menuName] = [
            'name' => $menuName,
            'kategori' => $menu['kategori'],
            'monthly_sales' => array_fill(1, 12, 0), // Initialize sales for each month to 0.
            'yearly_total' => 0, // Initialize the yearly total.
        ];
    }

    // Loop through transactions and accumulate sales per month for each menu.
    foreach ($transaksi as $trx) {
        $menuName = $trx['menu']; // Make sure this matches the 'menu' key in the transaction.
        $transactionMonth  = date('n', strtotime($trx['tanggal'])); // Extract the month from the transaction date.

        // Ensure the menu item exists in the data structure before adding the transaction total.
        if (isset($dataForTable[$menuName])) {
            $amount = $trx['total'];
            $dataForTable[$menuName]['monthly_sales'][$transactionMonth] += $amount;
            $dataForTable[$menuName]['yearly_total'] += $amount;

            // Accumulate the monthly totals.
            $monthlyTotals[$transactionMonth] += $amount;
            // Accumulate the grand total for the year.
            $yearlyTotal += $amount;
        } else {
            // If the menu item from the transaction doesn't exist in the menus list, you might want to log this as an error or add it dynamically.
            // For now, let's just log a message (you could also throw an exception or handle it as you see fit).
            Log::warning("Menu item from transaction not found in menus list: " . $menuName);
        }
    }
    $dataForTable['Totals'] = [
        'name' => 'Total',
        'monthly_sales' => $monthlyTotals,
        'yearly_total' => $yearlyTotal,
    ];
    // $dataForTable now contains the structured data with sales for each menu item per month.
    return $dataForTable;
    }
}
