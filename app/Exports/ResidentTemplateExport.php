<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Resident\App\Models\ResidentForm;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PHPUnit\Metadata\After;

class ResidentTemplateExport implements WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;

    protected $maxRows = 1001;
    protected $dynamicHeadings = [];

    public function __construct()
    {
        $this->dynamicHeadings = $this->getDynamicHeadings();
    }

    protected function getDynamicHeadings()
    {
        return ResidentForm::pluck('name')->toArray();
    }

    public function headings(): array
    {
        $defaultHeadings = [
            'NIK*',
            'Nomor KK*',
            'Nama Lengkap*',
            'Jenis Kelamin*',
            'Tempat Lahir*',
            'Tanggal Lahir*',
            'Agama*',
            'Pekerjaan*',
            'Pendidikan Terakhir*',
            'Status Pernikahan*',
            'Hubungan Keluarga*',
            'Alamat*',
            'Rt*',
            'Rw*',
            'Dusun/Kelurahan',
            'Status Kematian*',
            'Kewarganegaraan*',
            'Tanggal Pindah/Keluar',
        ];

        return array_merge($defaultHeadings, $this->dynamicHeadings);
    }

    public function registerEvents(): array
    {
        $dynamicHeadingCount = count($this->dynamicHeadings);
        $defaultHeadingCount = count($this->headings()) - $dynamicHeadingCount;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($defaultHeadingCount, $dynamicHeadingCount) {
                $sheet = $event->sheet->getDelegate();

                $totalHeadingCount = $defaultHeadingCount + $dynamicHeadingCount;

                // $requiredColumns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q'];

                $dropdowns = [
                    'D' => array_values(getGenderList()),
                    'G' => array_values(getReligionList()),
                    'H' => array_values(getJobList()),
                    'I' => array_values(getEducationList()),
                    'J' => array_values(getMaritalStatusList()),
                    'K' => array_values(getFamilyRelationshipList()),
                    'P' => array_values(getDeathStatusList()),
                    'Q' => array_values(getCitizenshipList()),
                ];

                $numberFormats = [
                    'A' => NumberFormat::FORMAT_TEXT,
                    'B' => NumberFormat::FORMAT_TEXT,
                    'M' => NumberFormat::FORMAT_TEXT,
                    'N' => NumberFormat::FORMAT_TEXT,
                    'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'R' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                ];

                $validations = [
                    'A' => ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=AND(NOT(ISBLANK(A2)), ISNUMBER(VALUE(A2)), LEN(A2)=16)', 'error' => 'NIK harus 16 digit angka dan wajib diisi.'],
                    'B' => ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=AND(NOT(ISBLANK(B2)), ISNUMBER(VALUE(B2)), LEN(B2)=16)', 'error' => 'Nomor KK harus 16 digit angka dan wajib diisi.'],
                    'M' => ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=NOT(ISBLANK(M2))', 'error' => 'RT wajib diisi.'],
                    'N' => ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=NOT(ISBLANK(N2))', 'error' => 'RW wajib diisi.'],
                    'F' => ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=AND(NOT(ISBLANK(F2)), ISNUMBER(F2), F2 < TODAY())', 'error' => 'Tanggal lahir harus valid (DD-MM-YYYY), tidak boleh kosong, dan tidak melebihi hari ini.'],
                    'R' => ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=OR(ISBLANK(R2), AND(ISNUMBER(R2), R2 > DATE(1900,1,1)))', 'error' => 'Jika diisi, tanggal harus valid (DD-MM-YYYY).'],
                ];

                foreach (['C', 'E', 'L'] as $col) {
                    $validations[$col] = ['type' => DataValidation::TYPE_CUSTOM, 'formula' => '=NOT(ISBLANK(' . $col . '2))', 'error' => 'Kolom ini wajib diisi.'];
                }

                for ($dynamicColIndex = $defaultHeadingCount; $dynamicColIndex < $totalHeadingCount; $dynamicColIndex++) {
                    $columnLetter = Coordinate::stringFromColumnIndex($dynamicColIndex + 1);

                    $numberFormats[$columnLetter] = NumberFormat::FORMAT_TEXT;

                    $validations[$columnLetter] = [
                        'type' => DataValidation::TYPE_CUSTOM,
                        'formula' => '=TRUE',
                        'error' => 'Kolom ini opsional dan diizinkan kosong.',
                        'allow_blank' => true,
                    ];
                }

                for ($i = 2; $i <= $this->maxRows; $i++) {
                    foreach ($numberFormats as $column => $format) {
                        $sheet->getStyle($column . $i)
                            ->getNumberFormat()
                            ->setFormatCode($format);
                    }

                    foreach ($dropdowns as $column => $options) {
                        $dropdownValues = '"' . implode(',', $options) . '"';

                        $validation = $sheet->getCell($column . $i)->getDataValidation();
                        $validation->setType(DataValidation::TYPE_LIST);
                        $validation->setErrorStyle(DataValidation::STYLE_STOP);
                        $validation->setShowErrorMessage(true);
                        $validation->setErrorTitle('Pilihan Tidak Valid');
                        $validation->setError('Pilih dari daftar yang tersedia.');
                        $validation->setShowDropDown(true);
                        $validation->setFormula1($dropdownValues);

                        if (!isset($validations[$column])) {
                            $validation->setAllowBlank(false);
                        }
                    }

                    foreach ($validations as $column => $rule) {
                        $validation = $sheet->getCell($column . $i)->getDataValidation();

                        $isComplexValidation = in_array($column, ['A', 'B', 'F', 'R']);
                        $hasDropdown = isset($dropdowns[$column]);
                        $colIndex = Coordinate::columnIndexFromString($column) - 1;

                        if (!$hasDropdown || $isComplexValidation || $colIndex >= $defaultHeadingCount) {
                            $validation->setType($rule['type']);
                            $validation->setErrorStyle(DataValidation::STYLE_STOP);
                            $validation->setShowErrorMessage(true);
                            $validation->setErrorTitle('Input Tidak Valid');
                            $validation->setError($rule['error']);

                            $isAllowBlank = (
                                $column == 'R' ||
                                (isset($rule['allow_blank']) && $rule['allow_blank'] === true)
                            );
                            $validation->setAllowBlank($isAllowBlank);

                            if (isset($rule['operator'])) {
                                $validation->setOperator($rule['operator']);
                            }
                            if (isset($rule['formula'])) {
                                $validation->setFormula1($rule['formula']);
                            }
                        }
                    }
                }
            },
        ];
    }
}
