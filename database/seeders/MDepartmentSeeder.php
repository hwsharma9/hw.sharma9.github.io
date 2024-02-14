<?php

namespace Database\Seeders;

use App\Models\MDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('dbtables.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/dbtables.php not loaded. Run [php artisan config:clear] and try again.');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($tableNames['m_departments'])->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $departments = [
            [
                'id' => 2,
                'title_hi' => 'पशुपालन',
                'title_en' => 'Animal Husbandry',
                'status' => 1
            ],
            [
                'id' => 3,
                'title_hi' => 'विमानन',
                'title_en' => 'Aviation',
                'status' => 1
            ],
            [
                'id' => 4,
                'title_hi' => 'पिछड़ा वर्ग तथा अल्पसंख्यक कल्याण ',
                'title_en' => 'Backward Classes & Minorities Welfare',
                'status' => 1
            ],
            [
                'id' => 5,
                'title_hi' => 'भोपाल गैस त्रासदी राहत एवं पुनवास',
                'title_en' => 'Bhopal Gas Tragedy Relief & Rehabilitation',
                'status' => 1
            ],
            [
                'id' => 7,
                'title_hi' => 'वाणिज्‍य एवं उद्योग',
                'title_en' => 'Commerce & Industry',
                'status' => 1
            ],
            [
                'id' => 8,
                'title_hi' => 'वाणिज्यिक कर ',
                'title_en' => 'Commercial Taxes',
                'status' => 1
            ],
            [
                'id' => 9,
                'title_hi' => 'सहकारिता विभाग',
                'title_en' => 'Cooperative ',
                'status' => 1
            ],
            [
                'id' => 10,
                'title_hi' => 'संस्कृति विभाग',
                'title_en' => 'Culture',
                'status' => 1
            ],
            [
                'id' => 11,
                'title_hi' => 'उर्जा',
                'title_en' => 'Energy',
                'status' => 1
            ],
            [
                'id' => 12,
                'title_hi' => 'किसान कल्याण एवं कृषि विकास',
                'title_en' => 'Farmer Welfare & Agriculture Development',
                'status' => 1
            ],
            [
                'id' => 13,
                'title_hi' => 'वित्‍त विभाग',
                'title_en' => 'Finance',
                'status' => 1
            ],
            [
                'id' => 14,
                'title_hi' => 'मछुआ कल्याण तथा मत्स्य विकास विभाग',
                'title_en' => 'Fisheries',
                'status' => 1
            ],
            [
                'id' => 15,
                'title_hi' => 'खाद्य, नागरिक आपूर्ति एवं उपभोक्ता संरक्षण',
                'title_en' => 'Food, Civil Supplies & Consumer Protection',
                'status' => 1
            ],
            [
                'id' => 16,
                'title_hi' => 'वन विभाग',
                'title_en' => 'Forest',
                'status' => 1
            ],
            [
                'id' => 17,
                'title_hi' => 'सामान्‍य प्रशासन विभाग',
                'title_en' => 'General Administration ',
                'status' => 1
            ],
            [
                'id' => 18,
                'title_hi' => 'उच्च शिक्षा',
                'title_en' => 'Higher Education',
                'status' => 1
            ],
            [
                'id' => 19,
                'title_hi' => 'गृह विभाग',
                'title_en' => 'Home',
                'status' => 1
            ],
            [
                'id' => 20,
                'title_hi' => ' उद्यानिकी तथा खाद्य प्रसंस्करण विभाग',
                'title_en' => 'Horticulture & Food Processing',
                'status' => 1
            ],
            [
                'id' => 21,
                'title_hi' => 'पर्यावरण ',
                'title_en' => 'Housing & Environment',
                'status' => 1
            ],
            [
                'id' => 22,
                'title_hi' => 'आयुष',
                'title_en' => 'Indian Systems of Medicine & Homeopathy (Ayush)',
                'status' => 1
            ],
            [
                'id' => 24,
                'title_hi' => 'जेल ',
                'title_en' => 'Jail',
                'status' => 1
            ],
            [
                'id' => 25,
                'title_hi' => 'श्रम विभाग',
                'title_en' => 'Labour',
                'status' => 1
            ],
            [
                'id' => 26,
                'title_hi' => 'विधि और विधायी कार्य विभाग',
                'title_en' => 'Law & Legislative Affairs',
                'status' => 1
            ],
            [
                'id' => 28,
                'title_hi' => 'चिकित्सा शिक्षा',
                'title_en' => 'Medical Education',
                'status' => 1
            ],
            [
                'id' => 29,
                'title_hi' => 'खनिज साधन',
                'title_en' => 'Mineral Resources',
                'status' => 1
            ],
            [
                'id' => 32,
                'title_hi' => 'कोष एवं लेखा',
                'title_en' => 'MP Treasury',
                'status' => 1
            ],
            [
                'id' => 35,
                'title_hi' => 'नर्मदा घाटी विकास',
                'title_en' => 'Narmada Valley Development',
                'status' => 1
            ],
            [
                'id' => 37,
                'title_hi' => 'पंचायत और ग्रामीण विकास ',
                'title_en' => 'Panchayat & Rural Development',
                'status' => 1
            ],
            [
                'id' => 38,
                'title_hi' => 'संसदीय कार्य विभाग',
                'title_en' => 'Parliamentary Affairs',
                'status' => 1
            ],
            [
                'id' => 39,
                'title_hi' => 'योजना आर्थिक एवं सांख्यिकी',
                'title_en' => 'Planning, Economics & Statistics',
                'status' => 1
            ],
            [
                'id' => 42,
                'title_hi' => 'लोक स्‍वास्‍थ्‍य एवं परिवार कल्‍याण ',
                'title_en' => 'Public Health & Family Welfare',
                'status' => 1
            ],
            [
                'id' => 43,
                'title_hi' => 'लोक स्वास्थ्य यांत्रिकी',
                'title_en' => 'Public Health Engineering',
                'status' => 1
            ],
            [
                'id' => 44,
                'title_hi' => 'जनसंपर्क',
                'title_en' => 'Public Relations',
                'status' => 1
            ],
            [
                'id' => 45,
                'title_hi' => ' लोक सेवा प्रबंधन विभाग',
                'title_en' => 'Public Service Management System',
                'status' => 1
            ],
            [
                'id' => 46,
                'title_hi' => 'लोक निर्माण विभाग',
                'title_en' => 'Public Works',
                'status' => 1
            ],
            [
                'id' => 47,
                'title_hi' => 'राहत एवं पुनर्वास',
                'title_en' => 'Rehabilitation',
                'status' => 1
            ],
            [
                'id' => 48,
                'title_hi' => 'धार्मिक न्यास',
                'title_en' => 'Religious Trusts and Endowments',
                'status' => 1
            ],
            [
                'id' => 49,
                'title_hi' => 'राजस्‍व विभाग',
                'title_en' => 'Revenue',
                'status' => 1
            ],
            [
                'id' => 50,
                'title_hi' => 'कुटीर एवं ग्रामोउद्योग विभाग',
                'title_en' => 'Rural Industries',
                'status' => 1
            ],
            [
                'id' => 51,
                'title_hi' => 'अनुसूचित जाति विकास',
                'title_en' => 'Scheduled Caste & Scheduled Tribe Welfare',
                'status' => 1
            ],
            [
                'id' => 52,
                'title_hi' => 'स्कूल शिक्षा विभाग',
                'title_en' => 'School Education',
                'status' => 1
            ],
            [
                'id' => 53,
                'title_hi' => 'विज्ञान एवं प्रौद्योगिकी विभाग',
                'title_en' => 'Science & Technology',
                'status' => 1
            ],
            [
                'id' => 54,
                'title_hi' => 'सामाजिक न्‍याय विभाग',
                'title_en' => 'Social Welfare',
                'status' => 1
            ],
            [
                'id' => 55,
                'title_hi' => 'खेल और युवा कल्‍याण',
                'title_en' => 'Sports & Youth Welfare',
                'status' => 1
            ],
            [
                'id' => 56,
                'title_hi' => 'तकनीकी शिक्षा एवं कौशल विकास ',
                'title_en' => 'Technical Education and Man Power Planning',
                'status' => 1
            ],
            [
                'id' => 57,
                'title_hi' => 'पर्यटन ',
                'title_en' => 'Tourism',
                'status' => 1
            ],
            [
                'id' => 58,
                'title_hi' => 'परिवहन',
                'title_en' => 'Transport',
                'status' => 1
            ],
            [
                'id' => 59,
                'title_hi' => 'नगरीय विकास एवं आवास',
                'title_en' => 'Urban Administration & Development',
                'status' => 1
            ],
            [
                'id' => 61,
                'title_hi' => 'जल संसाधन ',
                'title_en' => 'Water Resources',
                'status' => 1
            ],
            [
                'id' => 62,
                'title_hi' => 'महिला एवं बाल विकास विभाग',
                'title_en' => 'Women & Child Development',
                'status' => 1
            ],
            [
                'id' => 64,
                'title_hi' => 'नवीन एवं नवकरणीय उर्जा विभाग',
                'title_en' => 'New and Renewable Energy',
                'status' => 1
            ],
            [
                'id' => 67,
                'title_hi' => 'उद्योग नीति एवं निवेश प्रोत्साहन',
                'title_en' => 'Industrial Policy and Investment Promotion Department',
                'status' => 1
            ],
            [
                'id' => 68,
                'title_hi' => 'आदिम जाति कल्याण विभाग',
                'title_en' => 'Tribal Affairs Department',
                'status' => 1
            ],
            [
                'id' => 70,
                'title_hi' => 'प्रवासी भारतीय विभाग',
                'title_en' => 'Overseas Indians',
                'status' => 1
            ],
            [
                'id' => 71,
                'title_hi' => 'सूक्ष्म,लघु और मध्यम उद्यम विभाग',
                'title_en' => 'Micro, Small & Medium Enterprises',
                'status' => 1
            ],
        ];
        MDepartment::insert($departments);
    }
}
