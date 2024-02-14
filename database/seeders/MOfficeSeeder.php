<?php

namespace Database\Seeders;

use App\Models\MOffice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MOfficeSeeder extends Seeder
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
        DB::table($tableNames['m_offices'])->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $offices = [
            [
                'fk_department_id' => 65,
                'title_en' => 'Comandant General Home guard',
                'title_hi' => 'कमांडेंट होमगार्ड'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Public Prosecution Directorate',
                'title_hi' => 'लोक अभियोजन संचालनालय'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Disaster management institute',
                'title_hi' => 'आपदा प्रबंध संस्‍थान'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Forensic Science Library',
                'title_hi' => 'फोरेंसिक साइंस लाइब्रेरी'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Homeguard Civil Defence and Disaster Management',
                'title_hi' => 'होमगार्ड नागरिक सुरक्षा एवं आपदा प्रबंधन'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Medico legal Institute',
                'title_hi' => 'मेडिको लीगल इंस्टिट्यूट'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'MP Police',
                'title_hi' => 'म.प्र. पुलिस'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Madhya Pradesh Police Housing And Infrastructure Development Corporation Limited',
                'title_hi' => 'मध्‍यप्रदेश पुलिस आवास एवं अधोसंरचना विकास निगम'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'State Soldier & Airmen Board',
                'title_hi' => 'स्टेट सोल्जर और एयरमेन बोर्ड'
            ],
            [
                'fk_department_id' => 58,
                'title_en' => 'MP State Road Transport Corporation',
                'title_hi' => 'मप्र राज्य सड़क परिवहन निगम'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Madhya Pradesh Labour Welfare Board',
                'title_hi' => 'मध्‍यप्रदेश श्रम कल्‍याण मंडल'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'MP State Pencil Karmakar Kalyan Mandal, Mandsour',
                'title_hi' => 'एमपी स्टेट पेंसिल कर्मकार कल्याण मंडल, मंदसौर'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Employees State Insurance Services',
                'title_hi' => 'कर्मचारी राज्य बीमा सेवाएं'
            ],
            [
                'fk_department_id' => 42,
                'title_en' => 'Controller Food and Drugs Administration',
                'title_hi' => 'नियंत्रक खाद्य एवं औषधि प्रशासन'
            ],
            [
                'fk_department_id' => 42,
                'title_en' => 'Director Public health and family walfare',
                'title_hi' => 'लोक स्वास्थ्य एवं परिवार कल्याण संचालनालय'
            ],
            [
                'fk_department_id' => 42,
                'title_en' => 'Directorate of Health Service',
                'title_hi' => 'स्वास्थ्य सेवा संचालनालय'
            ],
            [
                'fk_department_id' => 42,
                'title_en' => 'Madhya Pradesh Public Health Services Corporation Limited',
                'title_hi' => 'मध्य प्रदेश लोक स्वास्थ्य सेवा निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 42,
                'title_en' => 'Pharmacy Council',
                'title_hi' => 'फार्मेसी परिषद'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Board of secondary education',
                'title_hi' => 'माध्यमिक शिक्षा मंडल'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Directorate of National Cadet Core',
                'title_hi' => 'राष्ट्रीय कैडर कोर संचालनालय'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Directorate of Public Instruction',
                'title_hi' => 'लोक शिक्षण संचालनालय'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Madhya Pradesh text Book Corporation',
                'title_hi' => 'मध्य प्रदेश पाठ्य पुस्तक निगम'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Rajya Shiksha Kendra M.P.',
                'title_hi' => 'राज्य शिक्षा केंद्र म.प्र.'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'Directorate of Panchayati Raj',
                'title_hi' => 'पंचायती राज संचालनालय'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'Madhya Pradesh Rural Road Development Authority',
                'title_hi' => 'मध्य प्रदेश ग्रामीण सड़क विकास प्राधिकरण'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'MP Panchayat Raj Vitta Evam Gramin Vikas Nigam Ltd',
                'title_hi' => 'म.प्र.पंचायत राज वित्‍त एवं ग्रामीण विकास निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'MP Water and Land Management Institute',
                'title_hi' => 'म.प्र. जल और भूमि प्रबंधन संस्थान'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'State Land Use and Wastelands Development Board',
                'title_hi' => 'राज्य भूमि उपयोग और बंजर भूमि विकास बोर्ड'
            ],
            [
                'fk_department_id' => 44,
                'title_en' => 'Directorate of Public Relation',
                'title_hi' => 'जनसंपर्क संचालनालय'
            ],
            [
                'fk_department_id' => 44,
                'title_en' => 'Madhya Pradesh Madhyam',
                'title_hi' => 'मध्य प्रदेश माध्यम'
            ],
            [
                'fk_department_id' => 44,
                'title_en' => 'Makhanlal Chaturvedi Rasthtriya Patrakarita Viswavidhyalaya Sansthan',
                'title_hi' => 'माखनलाल चतुर्वेदी राष्ट्रीय पत्रकारिता विश्व विद्यालय संस्थान'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Directorate of social justice and disabled persons walfare',
                'title_hi' => 'सामाजिक न्याय और नि:शक्‍त कल्‍याण'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Directorate Food and civil suplies',
                'title_hi' => 'खाद्य और नागरिक आपूर्ति संचालनालय'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Controller, Weights and Measures',
                'title_hi' => 'नियंत्रक, बाट और माप'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Madhya Pradesh State Civil Supplies Corporation Limited',
                'title_hi' => 'मध्यप्रदेश स्टेट सिविल सप्लाईज कार्पोरेशन लिमिटेड'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Madhya Pradesh Warehousing and Logistics Corporation',
                'title_hi' => 'मध्यप्रदेश वेयरहाउसिंग एण्ड लाँजिस्टिक कार्पोरेशन'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'MP State Consumer Disputes Redressal Commission Bhopal',
                'title_hi' => 'म.प्र.राज्य उपभोक्ता विवाद प्रतितोषण आयोग भोपाल'
            ],
            [
                'fk_department_id' => 61,
                'title_en' => 'Directorate Water Resources',
                'title_hi' => 'जल संसाधन संचालनालय'
            ],
            [
                'fk_department_id' => 61,
                'title_en' => 'State flood contrl board',
                'title_hi' => 'राज्य बाढ़ नियंत्रण बोर्ड'
            ],
            [
                'fk_department_id' => 57,
                'title_en' => 'Institution of Hotel Management Catering technology and applied nutrition',
                'title_hi' => 'इंस्टीट्यूशन ऑफ होटल मैनेजमेंट कैटरिंग टेक्नोलॉजी एंड एप्लाइड न्यूट्रीशन'
            ],
            [
                'fk_department_id' => 57,
                'title_en' => 'Madhya Pradesh State Tourism Development Corporation Limited',
                'title_hi' => 'मध्यप्रदेश राज्य पर्यटन विकास निगम मर्यादित'
            ],
            [
                'fk_department_id' => 57,
                'title_en' => 'Madhya Pradesh State Tourism Board',
                'title_hi' => 'मध्यप्रदेश राज्य पर्यटन बोर्ड'
            ],
            [
                'fk_department_id' => 43,
                'title_en' => 'Madhya Pradesh Jal Nigam Maryadit',
                'title_hi' => 'मध्यप्रदेश जल निगम मर्यादित'
            ],
            [
                'fk_department_id' => 43,
                'title_en' => 'Public Health Engineering',
                'title_hi' => 'लोक स्‍वास्‍थ्‍य यांत्रिकी'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Directorate of Animal Husbandry',
                'title_hi' => 'पशुपालन संचालनालय'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'MP Rajya go-seva ayog',
                'title_hi' => 'म.प्र. राज्य गो-सेवा आयोग'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'MP rajya Pashu chikitsa parishad',
                'title_hi' => 'म.प्र. सांसद राज्य पशु चिकित्सा परिषद'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Madhya Pradesh State Co-operative Dairy Federation Limited',
                'title_hi' => 'म.प्र. स्टेट को-आँपरेटिव डेयरी फेडरेशन लिमिटेड'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Madhya Pradesh State Livestock and Poultry Development Corporation',
                'title_hi' => 'मध्यप्रदेश राज्य पशुधन एवं कुक्कुट विकास निगम'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Nanaji Deshmukh Veterinary Science University',
                'title_hi' => 'नानाजी देशमुख पशु चिकित्सा विज्ञान विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 14,
                'title_en' => 'Directorate of Fisheries',
                'title_hi' => 'मत्स्योद्योग संचालनालय'
            ],
            [
                'fk_department_id' => 14,
                'title_en' => 'MP Fisheries Federation',
                'title_hi' => 'म.प्र. फिशरीज फेडरेशन'
            ],
            [
                'fk_department_id' => 14,
                'title_en' => 'MP state fishries development corporation',
                'title_hi' => 'म.प्र. राज्य मत्स्य विकास निगम'
            ],
            [
                'fk_department_id' => 53,
                'title_en' => 'Madhya Pradesh Agency for Promotion of Information Technology',
                'title_hi' => 'मध्य प्रदेश एजेंसी फॉर प्रमोशन ऑफ़ इनफार्मेशन एंड टेक्नोलॉजी (मैप आईटी)'
            ],
            [
                'fk_department_id' => 53,
                'title_en' => 'Madhya Pradesh State Electronics Development Corporation Ltd.',
                'title_hi' => 'मध्य प्रदेश राज्य इलेक्ट्रॉनिक्स विकास निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 62,
                'title_en' => 'Directorate Of Women and Child Development',
                'title_hi' => 'महिला एवं बाल विकास संचालनालय'
            ],
            [
                'fk_department_id' => 62,
                'title_en' => 'MP Bal Adhikar sanrakshan ayog',
                'title_hi' => 'मध्यप्रदेश बाल अधिकार संरक्षण आयोग'
            ],
            [
                'fk_department_id' => 62,
                'title_en' => 'MP Rajya Mahila Ayog',
                'title_hi' => 'मध्यप्रदेश राज्य महिला आयोग'
            ],
            [
                'fk_department_id' => 62,
                'title_en' => 'Madhya Pradesh Women Finance and Development Corporation',
                'title_hi' => 'मध्यप्रदेश महिला वित्त एवं विकास निगम'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'Directorate of Handlooms, MP',
                'title_hi' => 'म.प्र. हथकरघा संचालनालय'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'Directorate of Sericulture',
                'title_hi' => 'रेशम संचालनालय'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'Handloom & Handicraft',
                'title_hi' => 'हाथकरधा एवं हस्तशिल्प'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'Madhya Pradesh Khadi and Village Industries Board',
                'title_hi' => 'मध्यप्रदेश खादी तथा ग्रामोद्योग बोर्ड'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'Madhya Pradesh Matikala Board',
                'title_hi' => 'मध्यप्रदेश माटीकला बोर्ड'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'Sant Ravidas Madhya Pradesh Hastashilp evam Hathkargha Vikas Nigam Limited',
                'title_hi' => 'संत रविदास मध्यप्रदेश हस्तशिल्प एवं हाथकरघा विकास निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 66,
                'title_en' => 'Directorate of denotifie, Nomadic and Semi-Nomadic Tribe Development',
                'title_hi' => 'राज्य विमुक्त घूमक्कड़ और अर्ध घुमाक्कड़ जाति विकास संचालनालय'
            ],
            [
                'fk_department_id' => 51,
                'title_en' => 'Office of the Commissioner Scheduled Caste Development',
                'title_hi' => 'कार्यालय आयुक्त अनुसूचित जाति विकास भोपाल'
            ],
            [
                'fk_department_id' => 51,
                'title_en' => 'Dr baba ambedkar national institute of social sciences mhow',
                'title_hi' => 'डॉ बाबा अंबेडकर राष्ट्रीय सामाजिक विज्ञान संस्थान महू'
            ],
            [
                'fk_department_id' => 51,
                'title_en' => 'MP scheduled caste finance development corporation',
                'title_hi' => 'म.प्र.अनुसूचित जाति वित्त विकास निगम'
            ],
            [
                'fk_department_id' => 51,
                'title_en' => 'The Madhya pradesh Rajya Anusuchit jait Ayog',
                'title_hi' => 'मध्य प्रदेश राज्य अनुसूचित जाति आयोग'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'MP Laghu Udyog Nigam Ltd',
                'title_hi' => 'म.प्र. लघु उद्योग निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 50,
                'title_en' => 'MP state textile corporation',
                'title_hi' => 'म.प्र.स्टेट टेक्सटाइल कार्पोरेशन'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'Madhya Pradesh Pollution Control Board',
                'title_hi' => 'मध्यप्रदेश प्रदूषण नियंत्रण बोर्ड'
            ],
            [
                'fk_department_id' => 53,
                'title_en' => 'Madhya Pradesh Council of Science & Technology',
                'title_hi' => 'म. प्र. विज्ञान एवं प्रौद्या‍ेगिकी परिषद'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'State Anand Sansthan',
                'title_hi' => 'राज्‍य आनंद संस्‍थान'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Sampada Directorate',
                'title_hi' => 'संपदा संचालनालय'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Madhya Pradesh State Garage',
                'title_hi' => 'मध्यप्रदेश स्‍टेट गैरेज'
            ],
            [
                'fk_department_id' => 37,
                'title_en' => 'Development Commissioner',
                'title_hi' => 'विकास आयुक्‍त'
            ],
            [
                'fk_department_id' => 42,
                'title_en' => 'National Health Mission',
                'title_hi' => 'राष्ट्रीय स्वास्थ्य मिशन'
            ],
            [
                'fk_department_id' => 54,
                'title_en' => 'Labour Commissioner',
                'title_hi' => 'श्रम आयुक्‍त'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Madhya Pradesh State Open School Education Board',
                'title_hi' => 'मध्यप्रदेश राज्य मुक्त स्कूल शिक्षा परिषद'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Police Headquaters',
                'title_hi' => 'पुलिस मुख्‍यालय'
            ],
            [
                'fk_department_id' => 65,
                'title_en' => 'Directorate of Sainik Welfare',
                'title_hi' => 'सैनिक कल्‍याण संचालनालय'
            ],
            [
                'fk_department_id' => 58,
                'title_en' => 'Transport Commissioner',
                'title_hi' => 'परिवहन आयुक्त'
            ],
            [
                'fk_department_id' => 1063,
                'title_en' => 'General Administration Department - Personnel',
                'title_hi' => 'सामान्य प्रशासन विभाग - कार्मिक'
            ],
            [
                'fk_department_id' => 2,
                'title_en' => 'Directorate of Animal Husbandry',
                'title_hi' => 'पशुपालन संचालनालय'
            ],
            [
                'fk_department_id' => 2,
                'title_en' => 'MP Rajya go-seva ayog',
                'title_hi' => 'म.प्र. राज्य गो-सेवा आयोग'
            ],
            [
                'fk_department_id' => 2,
                'title_en' => 'MP rajya Pashu chikitsa parishad',
                'title_hi' => 'म.प्र. सांसद राज्य पशु चिकित्सा परिषद'
            ],
            [
                'fk_department_id' => 2,
                'title_en' => 'Madhya Pradesh State Co-operative Dairy Federation Limited',
                'title_hi' => 'म.प्र. स्टेट को-आँपरेटिव डेयरी फेडरेशन लिमिटेड'
            ],
            [
                'fk_department_id' => 2,
                'title_en' => 'Madhya Pradesh State Livestock and Poultry Development Corporation',
                'title_hi' => 'मध्यप्रदेश राज्य पशुधन एवं कुक्कुट विकास निगम'
            ],
            [
                'fk_department_id' => 2,
                'title_en' => 'Nanaji Deshmukh Veterinary Science University',
                'title_hi' => 'नानाजी देशमुख पशु चिकित्सा विज्ञान विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 3,
                'title_en' => 'Directorate of Aviation',
                'title_hi' => 'संचालनालय विमानन'
            ],
            [
                'fk_department_id' => 4,
                'title_en' => 'Madhya Pradesh Waqf Board',
                'title_hi' => 'मध्यप्रदेश वक्फ बोर्ड'
            ],
            [
                'fk_department_id' => 4,
                'title_en' => 'Directorate Backward Classes and Minorities Welfare Department',
                'title_hi' => 'संचालनाल पिछड़ा वर्ग एवं अल्पसंख्यक कल्याण'
            ],
            [
                'fk_department_id' => 8,
                'title_en' => 'Commissionar commercial tax',
                'title_hi' => 'आयुक्त वाणिज्यिक कर'
            ],
            [
                'fk_department_id' => 8,
                'title_en' => 'Commissioner Excise',
                'title_hi' => 'आयुक्‍त आबकारी'
            ],
            [
                'fk_department_id' => 8,
                'title_en' => 'Inspector general of Registration and stamps',
                'title_hi' => 'महानिरीक्षक पंजीयक एवं मुद्रांक'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Directorate Farmer Welfare And Agriculture Development',
                'title_hi' => 'संचालनालय किसान कल्याण एवं कृषि विकास'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Jawaharlal Nehru Krishi Vishwa Vidyalaya',
                'title_hi' => 'जवाहरलाल नेहरू कृषि विश्व विद्यालय'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Madhya Pradesh State Seeds and Farm Development Corporation',
                'title_hi' => 'मध्‍यप्रदेश राज्‍य बीज एवं फार्म विकास निगम'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'MP Rajya Bhumi Vikas Nigam',
                'title_hi' => 'म.प्र. राज्‍य भूमि विकास निगम'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'MP Rajya Bij Avam Farm Vikas Nigam',
                'title_hi' => 'म.प्र. राज्य बिज अवम फार्म विकास निगम'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'MP Rajya Vipnan Board',
                'title_hi' => 'म.प्र. राज्य विपणन बोर्ड'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Madhya Pradesh State Agricultural Marketing Board',
                'title_hi' => 'मध्‍यप्रदेश राज्‍य कृषि विपणन बोर्ड'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'MP State Seed Certification Agency',
                'title_hi' => 'मध्य प्रदेश राज्य बीज प्रमाणन एजेंसी'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Rajmata Vijayaraje Scindia Krishi Vishwa Vidhyalaya - Gwalior',
                'title_hi' => 'राजमाता विजयाराजे सिंधिया कृषि विश्व विद्यालय - ग्वालियर'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Directorate of Agriculture Engineering',
                'title_hi' => 'कृषि अभियांत्रिकी संचालनालय'
            ],
            [
                'fk_department_id' => 12,
                'title_en' => 'Madhya Pradesh State Organic Certification Agency',
                'title_hi' => 'मध्‍यप्रदेश राज्‍य जैविक प्रमाणीकरण संस्‍था'
            ],
            [
                'fk_department_id' => 9,
                'title_en' => 'Directorate Cooperatives',
                'title_hi' => 'संचालनालय सहकारिता'
            ],
            [
                'fk_department_id' => 15,
                'title_en' => 'Directorate Food and civil suplies',
                'title_hi' => 'खाद्य और नागरिक आपूर्ति संचालनालय'
            ],
            [
                'fk_department_id' => 15,
                'title_en' => 'Controller, Weights and Measures',
                'title_hi' => 'नियंत्रक, बाट और माप'
            ],
            [
                'fk_department_id' => 15,
                'title_en' => 'Madhya Pradesh State Civil Supplies Corporation Limited',
                'title_hi' => 'मध्यप्रदेश स्टेट सिविल सप्लाईज कार्पोरेशन लिमिटेड'
            ],
            [
                'fk_department_id' => 15,
                'title_en' => 'Madhya Pradesh Warehousing and Logistics Corporation',
                'title_hi' => 'मध्यप्रदेश वेयरहाउसिंग एण्ड लाँजिस्टिक कार्पोरेशन'
            ],
            [
                'fk_department_id' => 15,
                'title_en' => 'MP State Consumer Disputes Redressal Commission Bhopal',
                'title_hi' => 'म.प्र.राज्य उपभोक्ता विवाद प्रतितोषण आयोग भोपाल'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'M P State Bamboo Mission',
                'title_hi' => 'म.प्र. राज्य बांस मिशन'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'MP Biodiversity board',
                'title_hi' => 'म.प्र.जैव विविधता बोर्ड'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'MP Eco tourism development board',
                'title_hi' => 'म.प्र. इको टूरिज्म डेवलपमेंट बोर्ड'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'Directorate of Forest',
                'title_hi' => 'संचालनालय वन'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'MP State forest development cor. Ltd',
                'title_hi' => 'म.प्र. राज्य वन विकास निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'MP State Minor Forest Produce Cooperative Federation Limited',
                'title_hi' => 'म.प्र. राज्य लघु वनोपज सहकारी संघ लिमिटेड'
            ],
            [
                'fk_department_id' => 16,
                'title_en' => 'State Forest Research Institute',
                'title_hi' => 'राज्य वन अनुसंधान संस्थान'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Governor House',
                'title_hi' => 'राज भवन'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Commissioner Office of Departmental enquiry',
                'title_hi' => 'आयुक्‍त विभागीय जांच'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Economic Offences Wing',
                'title_hi' => 'आर्थिक अपराध प्रकोष्ठ'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Madhya Pradesh Human Rights Commission',
                'title_hi' => 'मध्यप्रदेश मानव अधिकार आयोग'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Lokayukt',
                'title_hi' => 'लोकायुक्‍त'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Madhya Pradesh Bhawan',
                'title_hi' => 'मध्‍यप्रदेश भवन'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Madhya Pradesh Public Service Commission',
                'title_hi' => 'मध्यप्रदेश लोक सेवा आयोग'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'MP Administrative Tribunal',
                'title_hi' => 'म.प्र. प्रशासनिक न्यायाधिकरण'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Madhya Pradesh State Information Commission',
                'title_hi' => 'मध्यप्रदेश राज्य सूचना आयोग'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'RCVP Noronha Academy of Administration',
                'title_hi' => 'आरसीव्‍हीपी नरोन्‍हा प्रशासन एवं प्रबन्‍धकीय अकादमी'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Madhya Pradesh State Election Commission',
                'title_hi' => 'मध्यप्रदेश राज्य निर्वाचन आयोग'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'MP Commercial Tax Appellate Board, Bhopal',
                'title_hi' => 'मध्यप्रदेश राज्य कर्मचारी कल्याण समिति'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Madhya Pradesh State Policy and Planning Commission',
                'title_hi' => 'मध्यप्रदेश राज्य नीति एवं योजना आयोग'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'Vigilance Commission',
                'title_hi' => 'सतर्कता आयोग'
            ],
            [
                'fk_department_id' => 17,
                'title_en' => 'General Administration Department - HR',
                'title_hi' => 'सामान्‍य प्रशासन विभाग -HR'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Awadhesh Pratap Singh University - Rewa',
                'title_hi' => 'अवधेश प्रताप सिंह विश्वविद्यालय - रीवा'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Indira Kala sangeet viswavidhyalaya khairagarh',
                'title_hi' => 'इंदिरा कला संगीत विश्वविद्यालय खैरागढ़'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Jiwaji University - Gwalior',
                'title_hi' => 'जीवाजी विश्वविद्यालय - ग्वालियर'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Maharaja Chhatrasal Bundelkhand University',
                'title_hi' => 'महाराजा छत्रसाल बुंदेलखंड विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Madhya Pradesh Hindi Granth Academy',
                'title_hi' => 'मध्यप्रदेश हिन्दी ग्रन्थ अकादमी'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Directorate of Higher Education',
                'title_hi' => 'उच्च शिक्षा संचालनालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Institute of Social Science Research',
                'title_hi' => 'सामाजिक शोध संस्थान'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Natnagar Shodh Institute',
                'title_hi' => 'नटनागर शोध संस्थान'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Rashtriya Uchchatar Shiksha Abhiyan',
                'title_hi' => 'राष्ट्रीय उच्च्तर शिक्षा अभियान'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Barkatullah University',
                'title_hi' => 'बरकतउल्ला विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Devi Ahilya University',
                'title_hi' => 'देवी अहिल्या विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Rani Durgavati University',
                'title_hi' => 'रानी दुर्गावती विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Vikram University',
                'title_hi' => 'विक्रम विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Chhindwara University',
                'title_hi' => 'छिंदवाडा विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Madhya Pradesh Bhoj(Open) University',
                'title_hi' => 'मध्य प्रदेश भोज (मुक्त) विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Mahatma Gandhi Chitrakoot Gramodaya University',
                'title_hi' => 'महात्मा गाँधी चित्रकूट ग्रामोदय विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'National Law Institute University',
                'title_hi' => 'राष्ट्रीय विधि संस्थान विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Maharshi Panini Sanskrit Evam Vedic University',
                'title_hi' => 'महर्षि पाणिनि संस्कृत एवं वैदिक विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Atal Bihari Vajpayee Hindi University',
                'title_hi' => 'अटल बिहारी बाजपेयी हिंदी विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Dr. B.R. Ambedkar University of Social Sciences',
                'title_hi' => 'डा. बाबा साहेब आंबेडकर सामाजिक विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 18,
                'title_en' => 'Pandit S. N. Shukla University',
                'title_hi' => 'पंडित एस . एन शुक्ला विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Comandant General Home guard',
                'title_hi' => 'कमांडेंट होमगार्ड'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Public Prosecution Directorate',
                'title_hi' => 'लोक अभियोजन संचालनालय'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Disaster management institute',
                'title_hi' => 'आपदा प्रबंध संस्‍थान'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Forensic Science Library',
                'title_hi' => 'फोरेंसिक साइंस लाइब्रेरी'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Homeguard Civil Defence and Disaster Management',
                'title_hi' => 'होमगार्ड नागरिक सुरक्षा एवं आपदा प्रबंधन'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Medico legal Institute',
                'title_hi' => 'मेडिको लीगल इंस्टिट्यूट'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'MP Police',
                'title_hi' => 'म.प्र. पुलिस'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Madhya Pradesh Police Housing And Infrastructure Development Corporation Limited',
                'title_hi' => 'मध्‍यप्रदेश पुलिस आवास एवं अधोसंरचना विकास निगम'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'State Soldier & Airmen Board',
                'title_hi' => 'स्टेट सोल्जर और एयरमेन बोर्ड'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Sampada Directorate',
                'title_hi' => 'संपदा संचालनालय'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Madhya Pradesh State Garage',
                'title_hi' => 'मध्यप्रदेश स्‍टेट गैरेज'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Police Headquaters',
                'title_hi' => 'पुलिस मुख्‍यालय'
            ],
            [
                'fk_department_id' => 19,
                'title_en' => 'Directorate of Sainik Welfare',
                'title_hi' => 'सैनिक कल्‍याण संचालनालय'
            ],
            [
                'fk_department_id' => 20,
                'title_en' => 'Directorate of Horticulture and Food Processing',
                'title_hi' => 'उद्यान एवं खाद्य प्रसंस्करण संचालनलय'
            ],
            [
                'fk_department_id' => 20,
                'title_en' => 'Madhya Pradesh State Agro Industries Corporation Limited',
                'title_hi' => 'मध्यप्रदेश स्टेट एग्रो इण्डस्ट्रीज डेव्हलपमेंट कार्पोरेशन लिमिटेड'
            ],
            [
                'fk_department_id' => 21,
                'title_en' => 'Madhya Pradesh Pollution Control Board',
                'title_hi' => 'मध्यप्रदेश प्रदूषण नियंत्रण बोर्ड'
            ],
            [
                'fk_department_id' => 22,
                'title_en' => 'MP ayurvedic and unani medical and natural medical board',
                'title_hi' => 'म.प्र. आयुर्वेदिक और यूनानी चिकित्सा और प्राकृतिक चिकित्सा बोर्ड'
            ],
            [
                'fk_department_id' => 22,
                'title_en' => 'MP state Homeopathy council',
                'title_hi' => 'एमपी राज्य होम्योपैथी परिषद'
            ],
            [
                'fk_department_id' => 22,
                'title_en' => 'Pt. Khushilal Sharma Government (Autonomous) Ayurveda College and Institute',
                'title_hi' => 'पं. खुशीलाल शर्मा शासकीय (स्वायत्त) आयुर्वेद महाविद्यालय एवं संस्थान'
            ],
            [
                'fk_department_id' => 25,
                'title_en' => 'Madhya Pradesh Labour Welfare Board',
                'title_hi' => 'मध्‍यप्रदेश श्रम कल्‍याण मंडल'
            ],
            [
                'fk_department_id' => 25,
                'title_en' => 'MP State Pencil Karmakar Kalyan Mandal, Mandsour',
                'title_hi' => 'एमपी स्टेट पेंसिल कर्मकार कल्याण मंडल, मंदसौर'
            ],
            [
                'fk_department_id' => 25,
                'title_en' => 'Employees State Insurance Services',
                'title_hi' => 'कर्मचारी राज्य बीमा सेवाएं'
            ],
            [
                'fk_department_id' => 25,
                'title_en' => 'Labour Commissioner',
                'title_hi' => 'श्रम आयुक्‍त'
            ],
            [
                'fk_department_id' => 26,
                'title_en' => 'Department of Law and Legislative Affairs',
                'title_hi' => 'कानून और विधायी कार्य विभाग'
            ],
            [
                'fk_department_id' => 26,
                'title_en' => 'Registrar, High Court of Madhya Pradesh',
                'title_hi' => 'रजिस्‍ट्रार उच्च न्यायालय'
            ],
            [
                'fk_department_id' => 26,
                'title_en' => 'MP Arbitration Tribunal',
                'title_hi' => 'मध्य प्रदेश आर्बिट्रेशन ट्रिब्यूनल'
            ],
            [
                'fk_department_id' => 26,
                'title_en' => 'MP Vidhik seva Pradhikaran',
                'title_hi' => 'सांसद विधिक सेवा प्राधिकरण'
            ],
            [
                'fk_department_id' => 28,
                'title_en' => 'Directorate of Medical Education',
                'title_hi' => 'संचालनालय चिकित्‍सा शिक्षा'
            ],
            [
                'fk_department_id' => 28,
                'title_en' => 'M.P. Medical Science University - Jabalpur',
                'title_hi' => 'म.प्र. चिकित्सा विज्ञान विश्वविद्यालय - जबलपुर'
            ],
            [
                'fk_department_id' => 28,
                'title_en' => 'Madhya Pradesh Nurses Registration Council',
                'title_hi' => 'मध्यप्रदेश नर्सेस रजिस्ट्रेशन कौंसिल'
            ],
            [
                'fk_department_id' => 28,
                'title_en' => 'Madhya Pradesh State Dental Council',
                'title_hi' => 'म. प्र. राज्य दंत परिषद'
            ],
            [
                'fk_department_id' => 29,
                'title_en' => 'Directorate of Geology and Mining',
                'title_hi' => 'संचालनालय भौमिकी एवं खनिकर्म'
            ],
            [
                'fk_department_id' => 29,
                'title_en' => 'Madhya Pradesh State Mining Corporation Ltd',
                'title_hi' => 'मध्य प्रदेश राज्य खनन निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 39,
                'title_en' => 'Directorate of Economics and Statistics',
                'title_hi' => 'अर्थशास्त्र और सांख्यिकी संचालनालय'
            ],
            [
                'fk_department_id' => 39,
                'title_en' => 'MP state planning Board',
                'title_hi' => 'मध्य प्रदेश स्टेट प्लानिंग बोर्ड'
            ],
            [
                'fk_department_id' => 39,
                'title_en' => 'Madhya Pradesh Jan Abhiyan Parishad',
                'title_hi' => 'मध्य प्रदेश जन अभियान परिषद'
            ],
            [
                'fk_department_id' => 45,
                'title_en' => 'Atal Bihari Vajpayee Institute of Good Governance and Policy Analysis, Bhopal',
                'title_hi' => 'अटल बिहारी वाजपेयी सुशासन एवं नीति विश्लेषण संस्थान, भोपाल'
            ],
            [
                'fk_department_id' => 45,
                'title_en' => 'State Agency for Public Services',
                'title_hi' => 'राज्‍य लोक सेवा अभिकरण'
            ],
            [
                'fk_department_id' => 52,
                'title_en' => 'Board of secondary education',
                'title_hi' => 'माध्यमिक शिक्षा मंडल'
            ],
            [
                'fk_department_id' => 52,
                'title_en' => 'Directorate of National Cadet Core',
                'title_hi' => 'राष्ट्रीय कैडर कोर संचालनालय'
            ],
            [
                'fk_department_id' => 52,
                'title_en' => 'Directorate of Public Instruction',
                'title_hi' => 'लोक शिक्षण संचालनालय'
            ],
            [
                'fk_department_id' => 52,
                'title_en' => 'Madhya Pradesh text Book Corporation',
                'title_hi' => 'मध्य प्रदेश पाठ्य पुस्तक निगम'
            ],
            [
                'fk_department_id' => 52,
                'title_en' => 'Rajya Shiksha Kendra M.P.',
                'title_hi' => 'राज्य शिक्षा केंद्र म.प्र.'
            ],
            [
                'fk_department_id' => 52,
                'title_en' => 'Madhya Pradesh State Open School Education Board',
                'title_hi' => 'मध्यप्रदेश राज्य मुक्त स्कूल शिक्षा परिषद'
            ],
            [
                'fk_department_id' => 67,
                'title_en' => 'Board of industries and Mineral resources',
                'title_hi' => 'उद्योग और खनिज संसाधन बोर्ड'
            ],
            [
                'fk_department_id' => 67,
                'title_en' => 'Director Boilers',
                'title_hi' => 'बॉयलर संचालनालय'
            ],
            [
                'fk_department_id' => 67,
                'title_en' => 'Directorate of Industries and Employement',
                'title_hi' => 'उद्योग और रोजगार संचालनालय'
            ],
            [
                'fk_department_id' => 67,
                'title_en' => 'MP Industrial Development Corporation Limited',
                'title_hi' => 'म.प्र. औद्योगिक विकास निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 67,
                'title_en' => 'Madhya Pradesh Audyogik Kendra Vikas Nigam',
                'title_hi' => 'मध्य प्रदेश औद्योगिक केंद्र विकास निगम'
            ],
            [
                'fk_department_id' => 68,
                'title_en' => 'Tribal Affairs Directorate',
                'title_hi' => 'जनजातीय कार्य आयुक्‍त'
            ],
            [
                'fk_department_id' => 68,
                'title_en' => 'Tribal Affairs Regional Development office',
                'title_hi' => 'आदिम जाति क्षेत्रीय विकास योजनायें'
            ],
            [
                'fk_department_id' => 68,
                'title_en' => 'Tribal Research & Development Institute',
                'title_hi' => 'आदिम जाति अनुसंधान एवं विकास संस्थान'
            ],
            [
                'fk_department_id' => 68,
                'title_en' => 'Madhya Pradesh Tribal Finance and Development Corporation',
                'title_hi' => 'मध्य प्रदेश आदिवासी वित्त एवं विकास निगम'
            ],
            [
                'fk_department_id' => 68,
                'title_en' => 'MP employment and trainning council',
                'title_hi' => 'म.प्र. रोजगार एवं प्रशिक्षण परिषद'
            ],
            [
                'fk_department_id' => 68,
                'title_en' => 'MP rajya Anusuchit Janjati Ayog',
                'title_hi' => 'सांसद राज्य अनुसूचित जनजाति आयोग'
            ],
            [
                'fk_department_id' => 69,
                'title_en' => 'Directorate of social justice and disabled persons walfare',
                'title_hi' => 'सामाजिक न्याय और नि:शक्‍त कल्‍याण'
            ],
            [
                'fk_department_id' => 71,
                'title_en' => 'MP Laghu Udyog Nigam Ltd',
                'title_hi' => 'म.प्र. लघु उद्योग निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 71,
                'title_en' => 'MP state textile corporation',
                'title_hi' => 'म.प्र.स्टेट टेक्सटाइल कार्पोरेशन'
            ],
            [
                'fk_department_id' => 10,
                'title_en' => 'Dir. Of culture bhopal',
                'title_hi' => 'संस्कृति संचालनालय'
            ],
            [
                'fk_department_id' => 10,
                'title_en' => 'Directorate of Swaraj Sansthan',
                'title_hi' => 'स्‍वराज संस्‍थान संचालनालय'
            ],
            [
                'fk_department_id' => 10,
                'title_en' => 'Kalidas Akadami',
                'title_hi' => 'कालीदास अकादमी'
            ],
            [
                'fk_department_id' => 10,
                'title_en' => 'Madhya Pradesh Sanskrit Parishad',
                'title_hi' => 'मध्यप्रदेश संस्कृति परिषद'
            ],
            [
                'fk_department_id' => 10,
                'title_en' => 'MP urdu Akadami',
                'title_hi' => 'एमपी उर्दू अकादमी'
            ],
            [
                'fk_department_id' => 10,
                'title_en' => 'Directorate of Archaeological Archives and Museums',
                'title_hi' => 'पुरातत्व अभिलेखागार एवं संग्रहालय'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'MP Energy development corporation',
                'title_hi' => 'म. प्र. उर्जा विकास निगम'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Chief Engineer and Chief Electrical Inspectorate',
                'title_hi' => 'मुख्य अभियंता और मुख्य विद्युत निरीक्षणालय'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Madhya Pradesh Madhya Kshetra Vidyut Vitaran Company Limited',
                'title_hi' => 'म. प्र. मध्‍य क्षेत्र विद्युत वितरण कम्‍पनी लिमिटेड'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Madhya Pradesh Paschim Kshetra Vidyut Vitaran Company Limited',
                'title_hi' => 'म. प्र. पश्चिम क्षेत्र विद्युत वितरण कम्‍पनी लिमिटेड'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Madhya Pradesh Poorv Kshetra Vidyut Vitaran Company Limited',
                'title_hi' => 'म. प्र. पूर्व क्षेत्र विद्युत वितरण कम्‍पनी लिमिटेड'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Madhya Pradesh Power Generating Company limited',
                'title_hi' => 'म. प्र. पावर जनरेटिग कम्‍पनी लिमिटेड'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'MP Electricity Board',
                'title_hi' => 'म.प्र. बिजली बोर्ड'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Madhya Pradesh Electricity Regulatory Commission',
                'title_hi' => 'मध्‍यप्रदेश विद्युत नियामक आयोग'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'M.P. Power Management Company Limited',
                'title_hi' => 'म.प्र. पावर प्रबंधन कंपनी लिमिटेड'
            ],
            [
                'fk_department_id' => 11,
                'title_en' => 'Madhya Pradesh Power Transmission Company limited',
                'title_hi' => 'म.प्र. पावर ट्रासमिशन कम्‍पनी लिमिटेड'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Directorate of financial management information system',
                'title_hi' => 'वित्तीय प्रबंधन सूचना प्रणाली संचालनालय'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Directorate of Institutional Financing',
                'title_hi' => 'संस्थागत वित्तपोषण संचालनालय'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Directorate of Life Insurance, MP',
                'title_hi' => 'मध्‍यप्रदेश जीवन बीमा संचालनालय'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Directorate of Local Fund Audit Cell',
                'title_hi' => 'स्थानीय निधि लेखा परीक्षा प्रकोष्ठ संचालनालय'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Directorate of Treasuries and Accounts, Madhya Pradesh',
                'title_hi' => 'संचालनालय कोषालय एवं लेखा'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'MP Rajya Vitta Ayog.',
                'title_hi' => 'मध्य प्रदेश राज्य वित्‍त आयोग'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Madhya Pradesh State Finance Corporation',
                'title_hi' => 'मध्य प्रदेश राज्य वित्त निगम'
            ],
            [
                'fk_department_id' => 13,
                'title_en' => 'Directorate of Pension Provident Fund and Insurance',
                'title_hi' => 'संचालनालय पेंशन भविष्य निधि एवं बीमा'
            ],
            [
                'fk_department_id' => 24,
                'title_en' => 'Director General of Prisons and Correctional Services',
                'title_hi' => 'जेल एवं सुधारात्मक सेवाएं'
            ],
            [
                'fk_department_id' => 64,
                'title_en' => 'Madhya Pradesh Urja Vikas Nigam Limited',
                'title_hi' => 'मध्य प्रदेश ऊर्जा विकास निगम लिमिटेड'
            ],
            [
                'fk_department_id' => 46,
                'title_en' => 'Madhya Pradesh Road Development Corporation Limited',
                'title_hi' => 'मध्यप्रदेश रोड डेव्हलपमेंट कार्पोरेशन लिमिटेड'
            ],
            [
                'fk_department_id' => 46,
                'title_en' => 'MPPWD Engineer In Chief',
                'title_hi' => 'प्रमुख अभियंता ,लोक निर्माण विभाग'
            ],
            [
                'fk_department_id' => 49,
                'title_en' => 'Principal Revenue commissionar (PRC)',
                'title_hi' => 'प्रमुख राजस्व आयुक्त (PRC)'
            ],
            [
                'fk_department_id' => 49,
                'title_en' => 'Commissionar Land records and settlement (CLR)',
                'title_hi' => 'आयुक्त भू-अभिलेख (CLR)'
            ],
            [
                'fk_department_id' => 49,
                'title_en' => 'Land Reform Commission',
                'title_hi' => 'भूमि सुधार आयोग'
            ],
            [
                'fk_department_id' => 49,
                'title_en' => 'Government Press',
                'title_hi' => 'शासकीय मुद्रणालय'
            ],
            [
                'fk_department_id' => 49,
                'title_en' => 'Madhya Pradesh Board of Revenue',
                'title_hi' => 'मध्य प्रदेश राजस्व मंडल'
            ],
            [
                'fk_department_id' => 49,
                'title_en' => 'Commissioner Relief',
                'title_hi' => 'आयुक्‍त राहत'
            ],
            [
                'fk_department_id' => 55,
                'title_en' => 'Madya Pradesh Civil Service sports control board',
                'title_hi' => 'मध्य प्रदेश सिविल सेवा खेल नियंत्रण बोर्ड'
            ],
            [
                'fk_department_id' => 56,
                'title_en' => 'Directorate of Employment Madhya Pradesh',
                'title_hi' => 'मध्य प्रदेश रोजगार संचालनालय'
            ],
            [
                'fk_department_id' => 56,
                'title_en' => 'Directorate of Skill Development',
                'title_hi' => 'कौशल विकास संचालनलाय'
            ],
            [
                'fk_department_id' => 56,
                'title_en' => 'Directorate of Technical Education',
                'title_hi' => 'तकनीकी शिक्षा संचालनालय'
            ],
            [
                'fk_department_id' => 56,
                'title_en' => 'MP State skill development and employment Guarantee Board',
                'title_hi' => 'मप्र राज्य कौशल विकास और रोजगार गारंटी परिषद'
            ],
            [
                'fk_department_id' => 56,
                'title_en' => 'Professional Examination Board, Bhopal',
                'title_hi' => 'प्रोफेशनल एग्जामिनेशन बोर्ड, भोपाल'
            ],
            [
                'fk_department_id' => 56,
                'title_en' => 'Rajiv Gandhi Proudyogiki Vishwavidyalaya',
                'title_hi' => 'राजीव गांधी प्रौद्योगिकी विश्वविद्यालय'
            ],
            [
                'fk_department_id' => 59,
                'title_en' => 'Directorate of Town and Country Planning',
                'title_hi' => 'संचालनालय नगर एवं ग्राम निवेश'
            ],
            [
                'fk_department_id' => 59,
                'title_en' => 'Directorate of Urban Administration & Developmemnt',
                'title_hi' => 'संचालनालय नगरीय प्रशासन एवं विकास'
            ],
            [
                'fk_department_id' => 59,
                'title_en' => 'Madhya Pradesh Housing & Infrastructure Development Board',
                'title_hi' => 'मध्यप्रदेश गृह निर्माण एवं अधोसंरचना विकास मण्डल'
            ],
            [
                'fk_department_id' => 59,
                'title_en' => 'MP Real Estate Regulatory Authority',
                'title_hi' => 'एमपी रियल एस्टेट नियामक प्राधिकरण'
            ],
            [
                'fk_department_id' => 59,
                'title_en' => 'MP Vikas Pradhikaran sangh',
                'title_hi' => 'सांसद विकास प्राधिकरण संघी'
            ],
            [
                'fk_department_id' => 59,
                'title_en' => 'Rajya Karmchari Aavas Nigam',
                'title_hi' => 'राज्य कर्मचारी आवास निगम'
            ],
            [
                'fk_department_id' => 35,
                'title_en' => 'Narmada Control Board',
                'title_hi' => 'नर्मदा नियंत्रण बोर्ड'
            ],
            [
                'fk_department_id' => 35,
                'title_en' => 'Narmada Valley Development Authority',
                'title_hi' => 'नर्मदा घाटी विकास प्राधिकरण'
            ]
        ];
        MOffice::insert($offices);
    }
}
