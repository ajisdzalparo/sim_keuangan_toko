<?php if ($yearly_data == null) : ?>
    <div class="alert alert-success mt-3" role="alert">
        <?= $this->session->flashdata('message'); ?>
    </div>
<?php endif ?>

<section>
    <div class="container-fluid-sm p-3 mx-4">
        <div class="row-sm mt-4 mb-3">
            <h3 style="font-size: 20px;" class="col-sm "><span class="fw-bold">Yearly</span> Revenue</h3>
        </div>
        <!-- Tombol Print -->
        <button onclick="printTable()" class="btn btn-primary">Print Transaksi Tahunan</button>
        <div class="row mt-5">
            <div class="table-resposive-sm">
                <table class="table" id="yearlyTable">
                    <thead class="bg-primary text-white fw-bold rounded-top">
                        <tr style="font-size: 20px;" class="text-md">
                            <th scope="col">#</th>
                            <th scope="col">Client</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Value</th>
                            <th scope="col">Total</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php if ($yearly_data == null) : ?>
                            <tr>
                                <td colspan="12" class="text-center h4 text-secondary">No Data</td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1 + $this->uri->segment(3); ?>
                            <?php foreach ($yearly_data as $row) : ?>
                                <tr style="font-size: 16px;">
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $row->client; ?></td>
                                    <td><?= $row->product_name; ?></td>
                                    <td>Rp <?= $row->price; ?></td>
                                    <td><?= $row->value; ?></td>
                                    <td>RP <?= $row->total_price; ?></td>
                                    <td><?= $row->date; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?= $links ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function printTable() {
        var divToPrint = document.getElementById('yearlyTable');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        var htmlContent = `
    <html>
    <head>
        <style>
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid black; padding: 8px; text-align: left; }
            th { background-color: #007bff; color: white; }
        </style>
    </head>
    <body onload="window.print()">
        <h1>Transaksi Tahunan</h1>
        ${divToPrint.outerHTML}
    </body>
    </html>`;
        newWin.document.write(htmlContent);
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 10);
    }
</script>
</script>
</script>
</script>