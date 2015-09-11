<?php

require_once 'Mage/Adminhtml/controllers/Promo/QuoteController.php';
class Bdt_Coupon_Adminhtml_Promo_QuoteController extends Mage_Adminhtml_Promo_QuoteController
{

    public function importAction()
    {
        $this->_initAction()
            ->_title($this->__('Import Coupon'));

        $this->_addContent($this->getLayout()->createBlock('coupon/adminhtml_promo_quote_import'));

        $this->renderLayout();
    }
    public function massImportAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                    try
                    {
                        $path = Mage::getBaseDir('media'). DS . 'import' . DS . 'coupon' . DS; // . date('ymd').'_pe_loyalty_voucher.csv';
                        //$path = Mage::getBaseDir().DS.'csv'.DS;  //desitnation directory
                        $fname = $_FILES['file']['name']; //file name
                        $fullname = $path.$fname;
                        $uploader = new Varien_File_Uploader('file'); //load class
                        $uploader->setAllowedExtensions(array('CSV','csv')); //Allowed extension for file
                        $uploader->setAllowCreateFolders(true); //for creating the directory if not exists
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        $uploader->save($path, $fname); //save the

                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('coupon')->__("File has been uploaded successfully."));
                        $this->_redirect('*/*/import');
                        return;

                    }
                    catch (Exception $e)
                    {
                        $fileType = "Invalid file format";
                    }
                }

                if ($fileType == "Invalid file format") {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('foundation')->__($fname." Invalid file format"));
                    $this->_redirect('*/*/');
                    return;
                }

                $result = Mage::getSingleton('coupon/coupon')->import($data['file']);

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('coupon')->__('%s coupon(s) imported successfully.<br/> %s coupon(s) were already exists.', $result['count'],$result['countNotImpt']));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/import');
            }

        }
    }
    public function exportCsvAction()
    {
        $fileName   = 'coupon.csv';
        $content    = $this->getLayout()->createBlock('coupon/adminhtml_promo_quote_grid')
            ->getCsv();
        //echo "<pre>";
        print_r($content);die;

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'coupon.xml';
        $content    = $this->getLayout()->createBlock('coupon/adminhtml_promo_quote_grid')
            ->getXml();


        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}
