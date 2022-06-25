<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    public $import_berkas = [
        'file_berkas' => 'ext_in[file_berkas,pdf,jpg,png]|max_size[file_berkas,1000]',
    ];

    public $import_berkas_errors = [
        'file_berkas' => [
            'ext_in'    => 'File Berkas hanya boleh diisi dengan file pdf, jpg atau png.',
            'max_size'  => 'File Excel maksimal 1mb'
        ]
    ];

    public $import_excel = [
        'imp_file' => 'uploaded[imp_file]|ext_in[imp_file,xls,xlsx]|max_size[imp_file,1000]',
    ];

    public $import_excel_errors = [
        'imp_file' => [
            'ext_in'    => 'File Excel hanya boleh diisi dengan xls atau xlsx.',
            'max_size'  => 'File Excel maksimal 1mb',
            'uploaded'  => 'Anda belum memilih File Excel yang akan di import'
        ]
    ];
}
