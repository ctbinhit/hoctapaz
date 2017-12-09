<?php

/* =====================================================================================================================
 *                                              MAIL SERVICE
 * ---------------------------------------------------------------------------------------------------------------------
 * 
 * =====================================================================================================================
 */

namespace App\Bcore\Services;

use Illuminate\Support\Facades\Mail;
use App\Bcore\Bcore;

class MailService extends Bcore {

    public $_subjet = null;
    // [Email address, name]
    public $_to = [null, null];
    public $_template_data = null;
    public $_template = null;
    public $_data_template = [
        'signup' => 'templates.components.mail.signup',
        'cart' => 'templates.components.mail.cart'
    ];
    private $_ERROR = false;
    private $_CONFIG = null;

    public function set_subject($pSubject) {
        $this->_subjet = $pSubject;
        return $this;
    }

    public function set_data($pData) {
        if (!is_array($pData)) {
            return null;
        }
        $this->_template_data = $pData;
        return $this;
    }

    public function set_template($pName) {
        // Nếu nằm trong danh sách template => set template
        if (in_array($pName, $this->_data_template)) {
            $this->_template = $this->_data_template[$pName];
        }
        return $this;
    }

    function __construct() {
        parent::__construct();
    }

    public function send($pEmails = null) {
        try {
            
            if ($pEmails != null) {
                $this->_to = [$pEmails, 'HocTapAz'];
            }

            if (!is_array($this->_to)) {
                return false;
            }
            if (count($this->_to) != 2) {
                return false;
            }

            Mail::send('templates.components.mail.signup', $this->_template_data, function($message) {
                $message->to($this->_to[0], $this->_to[1])->subject($this->_subjet);
            });
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

}
