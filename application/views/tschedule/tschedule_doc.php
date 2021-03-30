<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Tschedule List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tanggal</th>
		<th>Jam</th>
		<th>Tujuan</th>
		<th>Iddriver</th>
		<th>User</th>
		
            </tr><?php
            foreach ($tschedule_data as $tschedule)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tschedule->Tanggal ?></td>
		      <td><?php echo $tschedule->Jam ?></td>
		      <td><?php echo $tschedule->Tujuan ?></td>
		      <td><?php echo $tschedule->iddriver ?></td>
		      <td><?php echo $tschedule->User ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>