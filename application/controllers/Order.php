<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Order extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('Order_model','Product_model'));
    }

    function index() {

        $this->data['title'] = 'Order';
        $this->data['content'] = 'order/index';
        $this->data['product'] = $this->Product_model->getAll();
        $this->data['status'] = $this->orderStatus;
//        $this->data['dataList'] = $this->Order_model->getOrderData('','',array(),'where');
        $this->data['dataList'] = array();
        $this->load->view('layout', $this->data);
    }

    function paging() {
        $whereSearch = array();
        $pnumber = ($this->input->post('pnum')) ? $this->input->post('pnum') : 0;
        $paging = strtolower($this->input->post('page'));
        $limit = $this->input->post('limit');
        $totaldata = $this->input->post('totaldata');
        $orderTable = $this->input->post('order_table');
        $status = $this->input->post('order_status');
        $product = $this->input->post('order_prdc_id');
        $orderNumber = $this->input->post('user_nmbr');
        $page = $limit;

        if ($paging && $paging != 'page') {
            if ($paging == 'first') {
                $limit = 0;
                $page = $this->_limit;
                $pnumber = 1;
            } else if ($paging == 'last') {
                $limit = $totaldata - 10;
                $page = $this->_limit;
                $pnumber = round($totaldata / 10);
            } else if ($paging == 'next') {
                $page += 10;
                $limit = $page;
                $pnumber = $pnumber + 1;
            } else if ($paging == 'prev') {
                if ($limit > 0) {
                    $page -= 10;
                }
                $limit = $page;
                if ($pnumber > 1) {
                    $pnumber = $pnumber - 1;
                }
            } else {
                $limit = $totaldata;
                if ($pnumber > 1) {
                    $pnumber = 1;
                }
            }
        } else if ($paging == 'page') {
            if ($pnumber > 0) {
                $limit = (($this->_limit * $pnumber) - $this->_limit);
            } else if ($pnumber == 0) {
                $limit = 0;
            }
        }


        if ($orderTable != '') {
            $whereSearch["a.order_table"] = $orderTable;
        }
        if ($product != '') {
            $whereSearch["a.order_prdc_id"] = $product;
        }
        if ($status != '') {
            $whereSearch["a.order_status"] = $status;
        }
        if ($orderNumber != '') {
            $whereSearch["a.order_nmbr like '%$orderNumber%'"] = '';
        }
        $whereSearch["a.order_status"] = 'new';
        $result = $this->Order_model->getOrderData(0, 0, $whereSearch, 'where', 'a.order_user_name');
        $newData = '';
        if ($result) {
            $newData .= $this->searchTemplate($result);
        }
        
        $jsonData['result'] = true;
        $jsonData['pnumber'] = $pnumber;
        $jsonData['limit'] = isset($limit) ? $limit :0;
//        $jsonData['totaldata'] = sizeof($totalData);
        $jsonData['template'] = $newData;
        echo json_encode($jsonData, true);
    }

    function searchTemplate($data) {
        $template = '';
        foreach ($data as $index => $value) {
            $template .= '<tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="'.$value['id'].'" /></td>
                                <td>'.$value['order_nmbr'].'</td>
                                <td>'.$value['order_table'].'</td>
                                <td>'.$value['order_user_name'].'</td>
                                <td>'.$value['order_status'].'</td>
                                <td style="text-align: center">
                                    <div class="col-md-12">
                                        <div class="col-md-12" style="margin-bottom: 5px;">
                                            <div class="save_buttons text-center">
                                                <button class="btn btn-primary" type="button" style="width:87px" onclick="javascript:add_data(\''.base_url().'\', \''.$this->router->fetch_class().'\', \''.$value['id'].'\');">Detail</button>
                                            </div>
                                        </div>';
                                    $template .='</div>
                                    </div>
                                </td>
                            </tr>';
        }
        return $template;
    }

    function add() {
        $dataTables = array();
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->Order_model->getByCategory($where);
            $html = '';
            if ($dataTables[0]['order_detail'] != '') {
                $items = json_decode($dataTables[0]['order_detail'],true);
                foreach ($items as $index => $value) {
                    $html .= $this->add_product_order($value,true);
                }
                $this->data['itemsData'] = $html;
            }
            $this->data['title'] = 'Detail - Order';
        } else {
            $this->data['title'] = 'Tambah - Order';
        }

        $this->data['content'] = 'order/detail';
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }

    function add_product_order($tableData = array(), $html = false) {
        $product = $this->Product_model->getProducts('','',array('prdc_status'=>'ready'));
        $temp = '<tr>'
                .'<td style="width:50%"><div class="col-md-12">'
                . '<select id="item_id[]" name="item_id[]" class="form-control" '
                . 'onchange="javascript:get_price(this)">'
                . '<option value="">-- CHOOSE ONE --</option>';
                $selected = '';
                foreach($product as $index => $value) {
                    if (sizeof($tableData) > 0) {
                        if ($tableData['item_id'] == $value['id']) {
                            $selected = "selected='selected'";
                        } else {
                            $selected = '';
                        }
                    }
                    $temp .= '<option value="'.$value['id'].'" '.$selected.' price="'.$value['prdc_price'].'">'.$value['prdc_name'].'</option>';
                }
        $temp .='</select></div></td>'
                .'<td><input type="text" id="price[]" name="price[]" readonly '
                . 'class="form-control price_info" value="'.(isset($tableData['price'])? $tableData['price'] :'').'"/></td>'
                .'<td><input id="amount[]" name="amount[]" class="form-control amount" type="text" '
                . 'value="'.(isset($tableData['amount']) ? $tableData['amount']:'0').'" '
                . 'onkeyup="javascript:sum_total_row(this)"/></td>'
                .'<td><input id="total[]" name="total[]" class="form-control total_row" '
                . 'required="required" type="text" value="'.(isset($tableData['total']) ? $tableData['total']:'0').'" /></td>'
                . '<td><img src="' . base_url() . 'assets/themes/dist/images/delete.gif" onclick="javascript:delproduct(this);"/></td>'
                . '</tr>';
        if ($html) {
            return $temp;
        } else {
            $data['htmldata'] = $temp;
            echo json_encode($data);
        }
    }
    
    public function save() {
        if ($this->input->post('btncancel')) {
            redirect('order/index');
            return;
        }
        $new = true;
        $postData = $this->input->post();
        if (isset($postData['item_id'])) {
            $itemId = $postData['item_id'];
            unset($postData['item_id']);
        }

        if (isset($postData['price'])) {
            $prdcPrice = $postData['price'];
            unset($postData['price']);
        }

        if (isset($postData['amount'])) {
            $amount = $postData['amount'];
            unset($postData['amount']);
        }

        if (isset($postData['total'])) {
            $totalPrice = $postData['total'];
            unset($postData['total']);
        }

        if (isset($itemId)) {
            $postData['order_detail'] = array();
            for($i=0;$i<sizeof($itemId);$i++) {
                $dummy = array();
                $dummy['item_id'] = $itemId[$i];
                $dummy['price'] = $prdcPrice[$i];
                $dummy['amount'] = $amount[$i];
                $dummy['total'] = $totalPrice[$i];
                $postData['order_detail'][] = $dummy;
            }

            if (sizeof($postData['order_detail']) > 0) {
                $postData['order_detail'] = json_encode($postData['order_detail']);
            }
        }

        if ($postData['order_payment'] != '' && $postData['order_payment'] > 0) {
            $postData['order_status'] = 'paid';
        }
        
        $success = true;
        $message = 'Data berhasil tersimpan';
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }
        
        if ($new) { // add
            $id = $this->Order_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $postData['id'] = trim($this->input->post('id'));
            $this->Order_model->update($postData);
        }

        redirect('order/index');
    }

    function delete() {
        $this->load->model(array('Acl_Model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $value) {
                $dataOrder = $this->Order_model->check_user(array('id' => $value['id']));
                if ($dataOrder) {
                    $this->Order_model->delete($this->Order_model->_table, array('id' => $value['id']));
                }
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }

    function pdf_export() {
        $orderId = $this->input->post('order_id');
        $orderData = $this->Order_model->getOrderData('','',array('a.id' => $orderId),'where');
        
        require "mpdf/vendor/autoload.php";
        $this->data['title'] = "";
        $this->data['description'] = "";
        $this->data['reportData'] = $orderData;
        $this->data['sample_date'] = date('d/m/Y');
        $this->data['sample_time'] = date('H:i:s');
        //save into download log
//        $barcode = $saveData['barcode'] = $this->data['barcode'];
//        $pdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
        $pdf = new \Mpdf\Mpdf(['format' => [74,105]]);
//        $pdf->SetHTMLHeader('<div style="text-align: left; border-bottom: 1px solid #000000;">
//                    <img src="' . base_url() . 'barcode/bikin_barcode/' . $barcode . '"/></div>');
//        $pdf->SetHTMLFooter('<div style="text-align: left; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">
//                    <img src="' . base_url() . 'barcode/bikin_barcode/' . $barcode . '"/></div>');
        $html = $this->load->view('order/template-pdf', $this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
//        $pdfFilePath = "Evaluasi_pemakaian_bahan.pdf";
//        $pdf = $this->m_pdf->load();

        $pdf->WriteHTML($html);
//        $pdf->Output($pdfFilePath,'D');
        $pdf->Output();
    }
    
    function export_csv() {
        $sheetNum = 0;
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getProperties()->setCreator('Admin')
                ->setLastModifiedBy('Admin')
                ->setTitle('Self Asessment Report')
                ->setSubject('PhpSpreadsheet')
                ->setDescription('A Simple Excel Spreadsheet generated using PhpSpreadsheet.')
                ->setKeywords('Microsoft office 2013 php PhpSpreadsheet')
                ->setCategory('Self Asessment');
        $dateNow = str_replace('-', '_', date('Y-m-d'));
        $fileName = 'report_order_qrlab_' . str_replace(':', '_', $dateNow) . '.xlsx';

        $style = array(
            'alignment' => array(
                'vertical' => PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            ),
            'font' => array(
                'bold' => true,
            //                        'size'  => 15,
            //                        'name'  => 'Verdana'
            )
        );
        $bold = array(
            'font' => array(
                'bold' => true,
            //                        'size'  => 15,
            //                        'name'  => 'Verdana'
            )
        );
        $border = array('borders' => array(
                'allBorders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $borderRisk = array(
            'alignment' => array(
                'vertical' => PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $i = 1;
        if ($sheetNum > 0) {
            $objPHPExcel->createSheet();
        }

        $objPHPExcel->setActiveSheetIndex($sheetNum);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet($sheetNum)->getColumnDimension('M')->setWidth(20);

        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('A' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('B' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('C' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('D' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('E' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('F' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('G' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('H' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('I' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('J' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('K' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('L' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('M' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)->getStyle('N' . $i)->applyFromArray($style);
        $objPHPExcel->getActiveSheet($sheetNum)
                ->setCellValue("A" . $i, 'No.')
                ->setCellValue("B" . $i, 'No.Registrasi')
                ->setCellValue("C" . $i, 'NIK')
                ->setCellValue("D" . $i, 'Nama')
                ->setCellValue("E" . $i, 'Kategori')
                ->setCellValue("F" . $i, 'Produk')
                ->setCellValue("H" . $i, 'Lokasi')
                ->setCellValue("H" . $i, 'Tanggal Jadwal')
                ->setCellValue("I" . $i, 'Waktu')
                ->setCellValue("J" . $i, 'Harga')
                ->setCellValue("K" . $i, 'PPn')
                ->setCellValue("L" . $i, 'Total Harga')
                ->setCellValue("M" . $i, 'Paid')
                ->setCellValue("N" . $i, 'Status');


        $x = $i + 1;
        $no = 1;
        $userName = $this->input->post('user_name');
        $userIdnt = $this->input->post('user_idnt');
        $dateFrom = $this->input->post('datefrom');
        $dateTo = $this->input->post('dateto');
        $location = $this->input->post('order_lctn_id');
        $product = $this->input->post('order_prdc_id');
        $status = $this->input->post('order_status');
        $regNumber = $this->input->post('user_reg_nmbr');
        $whereSearch = array();
        if ($userName != '') {
            $whereSearch["user.user_name like '%$userName%'"] = '';
        }
        if ($userIdnt != '') {
            $whereSearch["user.user_idnt like '%$userIdnt%'"] = $userIdnt;
        }

        if ($userIdnt != '') {
            $whereSearch["user.user_idnt like '%$userIdnt%'"] = '';
        }
        if ($location != '') {
            $whereSearch["a.order_lctn_id"] = $location;
        }
        if ($product != '') {
            $whereSearch["a.order_prdc_id"] = $product;
        }
        if ($status != '') {
            $whereSearch["a.order_status"] = $status;
        }
        if ($regNumber != '') {
            $whereSearch["a.order_reg_nmbr like '%$regNumber%'"] = '';
        }
        if ($dateFrom != '' && $dateTo != '') {
            $whereSearch['DATE(a.order_schd_date) >='] = date('Y-m-d', strtotime($dateFrom));
            $whereSearch['DATE(a.order_schd_date) <='] = date('Y-m-d', strtotime($dateTo));
        } else if ($dateFrom != '' && $dateTo == '') {
            $whereSearch['DATE(a.order_schd_date) ='] = date('Y-m-d', strtotime($dateFrom));
        } else if ($dateFrom == '' && $dateTo != '') {
            $whereSearch['DATE(a.order_schd_date) ='] = date('Y-m-d', strtotime($dateTo));
        }
        
        $dataReport = $this->Order_model->getOrderData(0, 0, $whereSearch, 'where', 'user.user_name');
        if ($dataReport) {
            $no=1;
            foreach($dataReport as $index => $value) { 
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('A' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('B' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('C' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('D' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('E' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('F' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('G' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('H' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('I' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('J' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('K' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('L' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('M' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)->getStyle('N' . $x)->applyFromArray($border);
                $objPHPExcel->getActiveSheet($sheetNum)
                        ->setCellValue("A" . $x, $no)
                        ->setCellValue("B" . $x, $value['order_reg_nmbr'])
                        ->setCellValue("C" . $x, " ".$value['user_idnt'])
                        ->setCellValue("D" . $x, $value['user_name'])
                        ->setCellValue("E" . $x, $value['ctgr_name'])
                        ->setCellValue("F" . $x, $value['prdc_name'])
                        ->setCellValue("G" . $x, $value['lctn_name'])
                        ->setCellValue("H" . $x, date('d/m/Y', strtotime($value['order_schd_date'])))
                        ->setCellValue("I" . $x, $value['schd_desc'].' : '.$value['schd_time_from'].' - '.$value['schd_time_to'])
                        ->setCellValue("J" . $x, $value['order_cost'])
                        ->setCellValue("K" . $x, $value['order_ppn'])
                        ->setCellValue("L" . $x, $value['order_total_cost'])
                        ->setCellValue("M" . $x, $value['is_paid'])
                        ->setCellValue("N" . $x, $value['order_status']);
                $no++;
                $x++;
            }
        }

        $objPHPExcel->getActiveSheet($sheetNum)->setTitle('exsport');
        $objWriter = new Xlsx($objPHPExcel); // instantiate Xlsx
//        $objWriter->save(APPPATH . '../uploaded_file/report/' . $fileName);
//        $filePaths[] = APPPATH . '../uploaded_file/report/' . $fileName;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        ob_end_clean();
        $objWriter->save('php://output');
    }
}