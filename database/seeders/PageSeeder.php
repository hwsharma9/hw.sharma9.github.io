<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $columns = [
            'id',
            'title_hi',
            'description_hi',
            'title_en',
            'description_en',
            'pre_url',
            'slug',
            'added_date',
            'added_by',
            'edit_date',
            'edit_by',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'is_default',
            'is_on_homepage',
            'banner',
            'is_sidebar',
            'sidebar_id',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ];
        $details = [
            [
                'id' => 1,
                'title_hi' => 'उद्देश्य',
                'description_hi' => '
\\r\\n	मध्‍यप्रदेश कार्य गुणवत्‍ता परिषद के उद्येश्‍य

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	
\\r\\n		आधारभूत परियोजनाओं की परिकल्‍पना एवं क्रियान्‍वयन हेतु ज्ञान एवं नवाचार आधारित सहयोग प्रदान करना।
\\r\\n	
\\r\\n		प्रौद्योगिकी उन्‍नयन एवं क्षमता निर्माण पर ध्‍यान केन्द्रित करना।
\\r\\n	
\\r\\n		कार्यविभागों को कार्यविभाग नियमावली, निविदा प्रपत्रों एवं क्‍वालिटी एश्‍यूरेंस मैनुअल में गुणात्‍मक संशोधन हेतु अन्‍राष्‍ट्रीय एवं राष्‍ट्रीय बेस्‍ट प्रेक्टिसेज के अनुसार सहयोग प्रदान करना।
\\r\\n	
\\r\\n		राज्‍यस्‍तरीय गुणवत्‍ता नियंत्रण प्रयोगशाला की स्‍थापना।
\\r\\n	
\\r\\n		शासकीय विभागों एवं ठेकेदारों द्वारा नियुक्‍त अभियंताओं को     प्रशिक्षण प्रदान करना।
\\r\\n	
\\r\\n		आधारभूत परियोजनाओं में नवाचार को प्रोत्‍साहित करना।
\\r\\n	
\\r\\n		परियोजनाओं की थर्ड पाटी निरीक्षण करना
\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Objective',
                'description_en' => '
\\r\\n	Objective of Madhya Pradesh Work Quality Council

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	
\\r\\n		To provide knowledge and innovation-based support for the Planning and implementation of basic projects.
\\r\\n	
\\r\\n		Focus on technology gradation and capacity building.
\\r\\n	
\\r\\n		Providing support to work departments for qualitative amendment in work department rules, tender forms and quality assurance manuals according to international and national best practices.
\\r\\n	
\\r\\n		Establishment of a state-level quality control laboratory.
\\r\\n	
\\r\\n		Provide training to engineers appointed by Government Departments and contractors.
\\r\\n	
\\r\\n		Encouraging innovation in infrastructure projects.
\\r\\n	
\\r\\n		Third-party inspection of projects.
\\r\\n
\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'objective',
                'added_date' => '2018-11-13 03:41:35',
                'added_by' => '1',
                'edit_date' => '2023-05-30 04:41:08',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 3,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 2,
                'title_hi' => 'त्वरित सम्पक',
                'description_hi' => '
\\r\\n	
\\r\\n		
\\r\\n			त्वरित सम्पक
\\r\\n		
\\r\\n			
\\r\\n				   About the chairman 
\\r\\n			
\\r\\n				   RTI 
\\r\\n			
\\r\\n				   Tender 
\\r\\n			
\\r\\n				   Awards 
\\r\\n			
\\r\\n				   Online softwares 
\\r\\n			
\\r\\n				   Directory 
\\r\\n			
\\r\\n				   Transfer Orders 
\\r\\n			
\\r\\n				   Email Addresses 
\\r\\n		
\\r\\n	
\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Quick Links',
                'description_en' => '
\\r\\n	
\\r\\n		
\\r\\n			Quick Links
\\r\\n		
\\r\\n			
\\r\\n				   About the chairman 
\\r\\n			
\\r\\n				   RTI 
\\r\\n			
\\r\\n				   Tender 
\\r\\n			
\\r\\n				   Awards 
\\r\\n			
\\r\\n				   Online softwares 
\\r\\n			
\\r\\n				   Directory 
\\r\\n			
\\r\\n				   Transfer Orders 
\\r\\n			
\\r\\n				   Email Addresses 
\\r\\n		
\\r\\n	
\\r\\n
',
                'pre_url' => 'page/content/',
                'slug' => 'quick-links',
                'added_date' => '2018-11-14 11:22:14',
                'added_by' => '1',
                'edit_date' => '2023-01-19 03:24:21',
                'edit_by' => '1',
                'meta_title' => 'test',
                'meta_keyword' => 'test',
                'meta_description' => 'test',
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 0,
                'sidebar_id' => 0,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 3,
                'title_hi' => 'संपर्क करें',
                'description_hi' => '

	

		

			

				पता :-

			

				 

			

				 

			

				मध्य प्रदेश सरकार

			

				 

			

				 

			

				मध्य प्रदेश कार्य गुणवत्ता परिषद

			

				 

			

				41 शिल्प भवन, अरेरा हिल्स भोपाल - 462011, मध्य प्रदेश

			

				 

			

				फ़ोन नंबर - 0755-2554330/2920285

		

	



	 

',
                'title_en' => 'Contact Us',
                'description_en' => '

	

		Address -

	

		 

	

		 

	

		Works Quality Council (MPWQC)

	

		 

	

		 

	

		Bhopal - 462011, Madhya Pradesh

	

		 

	

		 

	

		 

	

		Phone No.0755-2554330, 0755-2920285',
                'pre_url' => 'page/content/',
                'slug' => 'contact',
                'added_date' => '2018-11-14 05:16:20',
                'added_by' => '1',
                'edit_date' => '2023-06-30 02:16:26',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 4,
                'title_hi' => 'स्क्रीन रीडर',
                'description_hi' => '
	
		स्क्रीन रीडर

	
		वेबसाइट वर्ल्ड वाइड वेब कंसोर्टियम (W3C) वेब सामग्री Accessibility दिशानिर्देश (WCAG) 2.0 स्तर ए.ए. के साथ अनुपालन. यह दृश्य impairments के साथ लोगों को स्क्रीन पाठकों के रूप में सहायक प्रौद्योगिकियों का उपयोग कर वेबसाइट का उपयोग करने में सक्षम हो जाएगा|

	
		नीचे दी गई तालिका विभिन्न स्क्रीन पाठकों के बारे में जानकारी की सूची:

	
		विभिन्न स्क्रीन पाठकों के लिए संबंधित सूचना

	
क्रमांक	स्क्रीन रीडर	वेबसाइट	मुफ्त / वाणिज्यिक
1	जावस	Freedom Scientific	वाणिज्यिक
2	नॉन विजुअल डेस्कटॉप एक्सेस (ऍन.वी.डी.ऐ.)	NV Access	मुफ्त
	 

',
                'title_en' => 'Screen Reader',
                'description_en' => '
	
		Screen Reader

	
		The website complies with World Wide Web Consortium (W3C) Web Content Accessibility Guidelines (WCAG) 2.0 level AA. This will enable people with visual impairments access the website using assistive technologies, such as screen readers.

	
		Following table lists the information about different screen readers:

	
		Information related to the various screen readers

	
S.No.	Screen Reader	Website	Free / Commercial
1	JAWS	Freedom Scientific	Commercial
2	Non Visual Desktop Access (NVDA)	NV Access	Free
	 

',
                'pre_url' => 'page/content/',
                'slug' => 'screen-reader',
                'added_date' => '2018-11-15 02:35:31',
                'added_by' => '1',
                'edit_date' => '2018-11-29 04:58:19',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 0,
                'sidebar_id' => 0,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 5,
                'title_hi' => 'कॉपीराइट नीति',
                'description_hi' => '
\\r\\n	इस पृष्ठ के लिए जानकारी जल्द ही साझा की जाएगी!
\\r\\n
\\r\\n	 
',
                'title_en' => 'Copyright Policy',
                'description_en' => '
\\r\\n	Information For This Page Will Be Shared Soon!

',
                'pre_url' => 'page/content/',
                'slug' => 'copyright-policy',
                'added_date' => '2018-11-15 02:52:44',
                'added_by' => '1',
                'edit_date' => NULL,
                'edit_by' => '0',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 0,
                'sidebar_id' => 0,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 6,
                'title_hi' => 'हाइपरलिंक नीति',
                'description_hi' => '
\\r\\n	इस पृष्ठ के लिए जानकारी जल्द ही साझा की जाएगी!

',
                'title_en' => 'Hyperlink Policy',
                'description_en' => '
\\r\\n	Information For This Page Will Be Shared Soon!

',
                'pre_url' => 'page/content/',
                'slug' => 'hyperlink-policy',
                'added_date' => '2018-11-15 04:38:33',
                'added_by' => '1',
                'edit_date' => NULL,
                'edit_by' => '0',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 0,
                'sidebar_id' => 0,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 7,
                'title_hi' => 'उपयोग की शर्तें',
                'description_hi' => '
\\r\\n	इस पृष्ठ के लिए जानकारी जल्द ही साझा की जाएगी!
\\r\\n
\\r\\n	 
',
                'title_en' => 'Terms of Use',
                'description_en' => '
\\r\\n	Information For This Page Will Be Shared Soon!

',
                'pre_url' => 'page/content/',
                'slug' => 'terms-of-use',
                'added_date' => '2018-11-15 04:39:41',
                'added_by' => '1',
                'edit_date' => NULL,
                'edit_by' => '0',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 0,
                'sidebar_id' => 0,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 8,
                'title_hi' => 'संगठन संरचना',
                'description_hi' => '
\\r\\n	संगठन संरचना

',
                'title_en' => 'Organization Structure',
                'description_en' => '
\\r\\n	Organization Structure

',
                'pre_url' => 'page/content/',
                'slug' => 'organization-structure',
                'added_date' => '2023-02-28 05:31:54',
                'added_by' => '1',
                'edit_date' => '2023-03-03 04:40:31',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => 'combined.png',
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 9,
                'title_hi' => 'tester781',
                'description_hi' => '
\\r\\n	tester781

',
                'title_en' => 'tester781',
                'description_en' => '
\\r\\n	tester781

',
                'pre_url' => 'page/content/',
                'slug' => 'tester781',
                'added_date' => '2023-03-28 12:02:01',
                'added_by' => '1',
                'edit_date' => '2023-03-28 04:31:48',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 10,
                'title_hi' => 'हमारे बारे में',
                'description_hi' => '

	Welcome to e-Shiksha


	निर्माण कार्यों की गुणवत्ता सुनिश्चित करने के लिए राज्य निकाय के रूप में मध्यप्रदेश कार्य गुणवत्ता परिषद की स्थापना की गई है। इस परिषद का गठन विभिन्न कार्य विभागों के सचिवों की एक समिति के परामर्श के बाद किया गया था। समिति की संस्तुति के आधार पर राज्य सरकार द्वारा गुणवत्ता परिषद गठित करने का निर्णय लिया गया है। मध्य प्रदेश कार्य गुणवत्‍ता परिषद एक गैर-लाभकारी संगठन है, जो 14 जून 2022 को सोसायटी ऑफ रजिस्ट्रेशन एक्ट 1973   (वर्ष 1973 क्रम संख्या 44) के तहत पंजीकृत है।



	 



	कार्यों, सेवाओं और प्रक्रियाओं के स्वतंत्र तृतीय पक्ष मूल्यांकन के लिए एक तंत्र बनाने के लिए मध्यप्रदेश कार्य गुणवत्ता परिषद की स्‍थापना की गई है । यह बुनियादी ढांचा क्षेत्र और निर्माण कार्यों के सभी महत्वपूर्ण क्षेत्रों में प्रचार अपनाने और गुणवत्ता मानकों के पालन में राज्य स्तर पर एक महत्वपूर्ण भूमिका निभाता है। मध्य प्रदेश राज्य के नागरिकों के जीवन की गुणवत्ता और भलाई में सुधार करने में इसका महत्वपूर्ण प्रभाव पड़ेगा।



	 



	मध्यप्रदेश कार्य गुणवत्‍ता परिषद एक शासी निकाय और एक कार्यकारी निकाय द्वारा शासित है। शासी निकाय और कार्यकारी निकाय में निम्नलिखित सदस्‍य शामिल हैं-

',
                'title_en' => 'About Us',
                'description_en' => '

	Welcome to e-Shiksha


	eShiksha is an education management portal which simplifies the management and provides enormous facilities to an Institute. Our portal assists educators to manage, analyze and report extensive data, while making your institutes management “A cashless and paperless management”.


	 


	It covers all the aspects of educational business, including administrative, academic and accounting activities. With eShiksa, institutes can easily connect with students and parents which helps in student’s growth because it creates a single window for viewing various reports on the academic front and paying all kinds of institute fees online.
',
                'pre_url' => 'page/content/',
                'slug' => 'about-us',
                'added_date' => '2023-04-06 11:28:44',
                'added_by' => '2',
                'edit_date' => '2023-10-05 04:44:40',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 1,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 11,
                'title_hi' => 'मासिक प्रगति रिपोर्ट',
                'description_hi' => '
\\r\\n	
\\r\\n		
\\r\\n			
M.P. Works Quality Council
\\r\\n		
\\r\\n			
\\\"\\\"
\\r\\n		
\\r\\n			
\\\"\\\"
\\r\\n		
\\r\\n			SearchReset
\\r\\n	
\\r\\n	\\r\\n		\\r\\n			\\r\\n				\\r\\n				\\r\\n				\\r\\n				\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n				\\r\\n			\\r\\n		\\r\\n	
\\r\\n S.No.	\\r\\n Title	\\r\\n Publish Date	\\r\\n Link
\\r\\n Record not found
\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Monthly Progress Reports',
                'description_en' => '
\\r\\n	
\\r\\n		
\\r\\n			
M.P. Works Quality Council
\\r\\n		
\\r\\n			
\\\"\\\"
\\r\\n		
\\r\\n			
\\\"\\\"
\\r\\n		
\\r\\n			SearchReset
\\r\\n	
\\r\\n	\\r\\n		\\r\\n			\\r\\n				\\r\\n				\\r\\n				\\r\\n				\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n				\\r\\n			\\r\\n		\\r\\n	
\\r\\n S.No.	\\r\\n Title	\\r\\n Publish Date	\\r\\n Link
\\r\\n Record not found
\\r\\n
\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'reports',
                'added_date' => '2023-04-15 02:27:54',
                'added_by' => '1',
                'edit_date' => '2023-04-19 02:07:20',
                'edit_by' => '2',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 12,
                'title_hi' => 'माप पुस्तक पृष्ठ',
                'description_hi' => '
\\r\\n	
\\r\\n		
\\r\\n			
M.P. Works Quality Council
\\r\\n		
\\r\\n			SearchReset
\\r\\n	
\\r\\n	\\r\\n		\\r\\n			\\r\\n				\\r\\n				\\r\\n				\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n				\\r\\n			\\r\\n		\\r\\n	
\\r\\n S.No.	\\r\\n Title	\\r\\n Link
\\r\\n Record not found
\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Measurement Book Pages',
                'description_en' => '
\\r\\n	
\\r\\n		
\\r\\n			
M.P. Works Quality Council
\\r\\n		
\\r\\n			SearchReset
\\r\\n	
\\r\\n	\\r\\n		\\r\\n			\\r\\n				\\r\\n				\\r\\n				\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n				\\r\\n			\\r\\n		\\r\\n	
\\r\\n S.No.	\\r\\n Title	\\r\\n Link
\\r\\n Record not found
\\r\\n
\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'measurement-book-pages',
                'added_date' => '2023-04-17 05:27:08',
                'added_by' => '2',
                'edit_date' => '2023-04-20 04:12:05',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 13,
                'title_hi' => 'निर्माण विभाग मैनुअल',
                'description_hi' => '
\\r\\n	
\\r\\n		
\\r\\n			
M.P. Works Quality Council
\\r\\n		
\\r\\n			SearchReset
\\r\\n	
\\r\\n	\\r\\n		\\r\\n			\\r\\n				\\r\\n				\\r\\n				\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n				\\r\\n			\\r\\n		\\r\\n	
\\r\\n S.No.	\\r\\n Title	\\r\\n Link
\\r\\n Record not found
\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Works Departments Manual',
                'description_en' => '
\\r\\n	
\\r\\n		
\\r\\n			
M.P. Works Quality Council
\\r\\n		
\\r\\n			SearchReset
\\r\\n	
\\r\\n	\\r\\n		\\r\\n			\\r\\n				\\r\\n				\\r\\n				\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n				\\r\\n			\\r\\n		\\r\\n	
\\r\\n S.No.	\\r\\n Title	\\r\\n Link
\\r\\n Record not found
\\r\\n
\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'works-departments-manual',
                'added_date' => '2023-04-17 05:27:42',
                'added_by' => '2',
                'edit_date' => '2023-04-20 04:06:23',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 14,
                'title_hi' => 'सामान्य निकाय',
                'description_hi' => '
\\r\\n	
\\r\\nसामान्य निकाय
\\r\\n	
\\r\\n		 
\\r\\n
\\r\\n
\\r\\n	 
',
                'title_en' => 'General Body',
                'description_en' => '
\\r\\n	General Body

',
                'pre_url' => 'page/content/',
                'slug' => 'general-body',
                'added_date' => '2023-04-20 11:44:52',
                'added_by' => '2',
                'edit_date' => '2023-04-20 11:46:05',
                'edit_by' => '2',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 15,
                'title_hi' => 'शासी निकाय',
                'description_hi' => '
\\r\\n	शासी निकाय:

\\r\\n\\r\\n	\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n	\\r\\n
\\r\\n
\\r\\n क्रं

\\r\\n	\\r\\n
\\r\\n पदनाम

\\r\\n	\\r\\n
\\r\\n पद

\\r\\n
\\r\\n
\\r\\n 1

\\r\\n	\\r\\n
\\r\\n माननीय मुख्यमंत्री, म.प्र.शासन

\\r\\n	\\r\\n
\\r\\n अध्यक्ष

\\r\\n
\\r\\n
\\r\\n 2

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, सामान्य प्रशासन विभाग

\\r\\n	\\r\\n
\\r\\n उपाध्यक्ष

\\r\\n
\\r\\n
\\r\\n 3

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, वित्त विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 4

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, लोक निर्माण विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 5

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, जल संसाधन विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 6

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, लोक स्वास्थ्य यांत्रिकी विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 7

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, आवास एवं नगरीय विकास विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 8

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, ऊर्जा विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 9

\\r\\n	\\r\\n
\\r\\n माननीय मंत्री, म.प्र.शासन, पंचायत एवं ग्रामीण विकास विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 10

\\r\\n	\\r\\n
\\r\\n मुख्य सचिव, म.प्र.शासन

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 11

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव /प्रमुख सचिव म.प्र.शासन सामान्य प्रशासन विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 12

\\r\\n	\\r\\n
\\r\\n प्रमुख सचिव, म.प्र.शासन, लोक निर्माण विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 13

\\r\\n	\\r\\n
\\r\\n मुख्य कार्यकारी अधिकारी, म.प्र.कार्य गुणवत्‍ता परिषद

\\r\\n	\\r\\n
\\r\\n सदस्य सचिव

\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Governing Body',
                'description_en' => '
\\r\\n	Governing Body:

\\r\\n\\r\\n	\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n	\\r\\n
\\r\\n
\\r\\n No

\\r\\n	\\r\\n
\\r\\n Post

\\r\\n	\\r\\n
\\r\\n Designation

\\r\\n
\\r\\n
\\r\\n 1

\\r\\n	\\r\\n
\\r\\n Hon\'ble Chief Minister, Government of Madhya Pradesh

\\r\\n	\\r\\n
\\r\\n President

\\r\\n
\\r\\n
\\r\\n 2

\\r\\n	\\r\\n
\\r\\n Hon\'ble  Minister, Madhya Pradesh Government, General Administration Department

\\r\\n	\\r\\n
\\r\\n Vice President

\\r\\n
\\r\\n
\\r\\n 3

\\r\\n	\\r\\n
\\r\\n Hon\'ble Minister, Government of Madhya Pradesh, Finance Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 4

\\r\\n	\\r\\n
\\r\\n H Hon\'ble Minister, Government of Madhya Pradesh, Public Works Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 5

\\r\\n	\\r\\n
\\r\\n Hon\'ble Minister, Government of Madhya Pradesh, Water Resources Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 6

\\r\\n	\\r\\n
\\r\\n Hon\'ble Minister, Government of Madhya Pradesh, Department of Public Health Engineering

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 7

\\r\\n	\\r\\n
\\r\\n Hon\'ble Minister, Madhya Pradesh Government, Housing and Urban Development Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 8

\\r\\n	\\r\\n
\\r\\n Hon\'ble Minister, Government of Madhya Pradesh, Department of Energy

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 9

\\r\\n	\\r\\n
\\r\\n Hon\'ble Minister, Government of Madhya Pradesh, Panchayat and Rural Development Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 10

\\r\\n	\\r\\n
\\r\\n Chief Secretary, Government of Madhya Pradesh

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 11

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary / Principal Secretary Madhya Pradesh Government General Administration Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 12

\\r\\n	\\r\\n
\\r\\n Principal Secretary, Government of Madhya Pradesh, Public Works Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 13

\\r\\n	\\r\\n
\\r\\n Director General, MP Work Quality Council

\\r\\n	\\r\\n
\\r\\n member secretary

\\r\\n
\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'governing-body',
                'added_date' => '2023-04-20 11:51:14',
                'added_by' => '1',
                'edit_date' => '2023-07-06 05:21:37',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 16,
                'title_hi' => 'इतिहास',
                'description_hi' => '
\\r\\n	मध्य प्रदेश कार्य गुणवत्‍ता परिषद का इतिहास 

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	प्रदेश में पूर्व में कार्यरत गुणवत्ता जांच संस्था को और अधिक प्रभावी बनाने के लिए इसकी गतिविधियों का और विस्तार किया गया है। तदनुसार कार्यों की गुणवत्ता की निगरानी के लिए एक स्वतंत्र परिषद स्थापित करने की अनुशंसा, सरकार को प्रस्तुत की गई थी।  सरकार द्वारा अनुशंसा को स्वीकार करते हुए मध्यप्रदेश कार्य गुणवत्‍ता परिषद के नाम से एक गैर-लाभकारी स्वायत्त निकाय के रूप में एक स्वतंत्र परिषद स्थापित करने एवं सोसायटी पंजीकरण अधिनियम के तहत पंजीकृत करने का निर्णय लिया गया। मध्य प्रदेश कार्य गुणवत्ता परिषद की स्थापना 13 मई, 2022 को की गई है।

\\r\\n
\\r\\n	श्री अशोक शाह (से.नि.भा.प्र.से.) मध्‍यप्रदेश कार्य गुणवत्‍ता परिषद के प्रथम  महानिदेशक हैं।

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	 

',
                'title_en' => 'History',
                'description_en' => '
\\r\\n	History of Madhya Pradesh Work Quality Council

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	In order to make the Quality examining organization previously working in the state, more effective its activities have been further expanded. Accordingly, a recommendation for establishing an independent council to monitor the quality of work was submitted to the Government. Accepting the recommendations the Government decided to set up an independent council named as Madhya Pradesh Works Quality Council as a non-profitable autonomous body registered under the Society Registration Act. The Madhya Pradesh Works Quality Council has been established on 13th May 2022.

\\r\\n
\\r\\n	Shri Ashok Shah (Retd. IAS) is the first Director General of the Madhya Pradesh Works Quality Council.

\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'history',
                'added_date' => '2023-05-26 01:12:31',
                'added_by' => '1',
                'edit_date' => '2023-08-07 03:09:25',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 17,
                'title_hi' => 'दृष्टि',
                'description_hi' => '
\\r\\n	मध्य प्रदेश कार्य गुणवत्‍ता परिषद की दृष्टि

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	गुणवत्ता आकस्मिक नहीं है बल्कि यह एक आदत है। यह हमेशा अच्छे इरादे, ईमानदार प्रयास, बुद्धिमान दिशा और कुशल निष्पादन का परिणाम होता है। यह कई विकल्पों के बुद्धिमान विकल्प का प्रतिनिधित्व करता है एवं गुणवत्‍ता, शिल्प कौशल के कई मास्टर्स का संचयी अनुभव होता है।

\\r\\n
\\r\\n	गुणवत्ता का अर्थ है सही करना जब कोई नहीं देख रहा हो। मध्य प्रदेश कार्य गुणवत्ता परिषद का उद्देश्य इस राज्य को तकनीकी रूप से विकसित राज्य बनाने और राष्ट्रीय स्तर पर प्रतिस्पर्धात्मक बढ़त बनाने के लिए सभी कार्य विभागों, सेवा प्रदान करने वाली एजेंसियों में गुणवत्ता के लिए एक पेशेवर स्वभाव विकसित करना है।

\\r\\n
\\r\\n	हमारे माननीय प्रधान मंत्री श्री नरेंद्र मोदी जी के शब्द - "एक बार जब हम तय कर लेते हैं कि हमें कुछ करना है, तो हम मीलों आगे जा सकते हैं", हमें अपने राज्य में गुणवत्ता का मील का पत्थर हासिल करने के लिए प्रेरित करता है।

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	 

',
                'title_en' => 'Vision',
                'description_en' => '
\\r\\n	Vision of Madhya Pradesh Work Quality Council

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	Quality is not accidental but it is a habit. it is always the result of good intention, sincere efforts, intelligent direction and skilful execution. It represents the wise choice of many alternatives, the cumulative experience of many masters of craftsmanship.

\\r\\n
\\r\\n	Quality means doing right when no one is looking. Madhya Pradesh work quality council has aim to develop a professional temperament for quality in all works departments, service providing agencies to make this state a technologically developed state and to create a competitive edge at the National level. 

\\r\\n
\\r\\n	 The words of our Hon\'ble Prime Minister Shri Narendra  Modi -"Once we decide we have to do something, we can go miles ahead" inspires us to achieve the milestone of quality in our state.

\\r\\n
\\r\\n	 

\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'vision',
                'added_date' => '2023-05-30 12:12:00',
                'added_by' => '1',
                'edit_date' => '2023-05-30 04:33:35',
                'edit_by' => '1',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 18,
                'title_hi' => 'कार्यकारिणी निकाय',
                'description_hi' => '\\r\\n	\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n	\\r\\n
\\r\\n
\\r\\n क्रं

\\r\\n	\\r\\n
\\r\\n पदनाम

\\r\\n	\\r\\n
\\r\\n पद

\\r\\n
\\r\\n
\\r\\n 1

\\r\\n	\\r\\n
\\r\\n मुख्य सचिव, म.प्र.शासन

\\r\\n	\\r\\n
\\r\\n अध्यक्ष

\\r\\n
\\r\\n
\\r\\n 2

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव /प्रमुख सचिव म.प्र.शासन सामान्य प्रशासन विभाग

\\r\\n	\\r\\n
\\r\\n उपाध्यक्ष

\\r\\n
\\r\\n
\\r\\n 3

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव/प्रमुख सचिव, म.प्र.शासन वित्‍त विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 4

\\r\\n	\\r\\n
\\r\\n अतिरिक्‍त मुख्‍य सचिव/प्रमुख सचिव, म.प्र.शासन लोक निर्माण विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 5

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव/प्रमुख सचिव, म.प्र.शासन जल संसाधन विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 6

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव/प्रमुख सचिव, म.प्र.शासन लोक स्वास्थ्य यांत्रिकी विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 7

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव/प्रमुख सचिव, म.प्र.शासन, आवास एवं नगरीय विकास विभाग  

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 8

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव/प्रमुख सचिव, म.प्र.शासन, पंचायत एवं ग्रामीण विकास विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 9

\\r\\n	\\r\\n
\\r\\n अतिरिक्त मुख्य सचिव/प्रमुख सचिव, म.प्र.शासन,  ऊर्जा विभाग

\\r\\n	\\r\\n
\\r\\n सदस्य

\\r\\n
\\r\\n
\\r\\n 10

\\r\\n	\\r\\n
\\r\\n मुख्य कार्यकारी अधिकारी, म.प्र.कार्य गुणवत्‍ता परिषद

\\r\\n	\\r\\n
\\r\\n सदस्‍य सचिव

\\r\\n
\\r\\n
\\r\\n	 

',
                'title_en' => 'Executive Body',
                'description_en' => '\\r\\n	\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n		\\r\\n			\\r\\n			\\r\\n			\\r\\n		\\r\\n	\\r\\n
\\r\\n
\\r\\n S.No.

\\r\\n	\\r\\n
\\r\\n Post

\\r\\n	\\r\\n
\\r\\n Designation

\\r\\n
\\r\\n
\\r\\n 1

\\r\\n	\\r\\n
\\r\\n Chief Secretary, Government of Madhya Pradesh

\\r\\n	\\r\\n
\\r\\n President

\\r\\n
\\r\\n
\\r\\n 2

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary / Principal Secretary Madhya Pradesh Government General Administration Department

\\r\\n	\\r\\n
\\r\\n Vice President

\\r\\n
\\r\\n
\\r\\n 3

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary/Principal Secretary, MP Government Finance Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 4

\\r\\n	\\r\\n
\\r\\n Principal Secretary, Government of Madhya Pradesh, Public Works Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 5

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary / Principal Secretary, Government of Madhya Pradesh Water Resources Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 6

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary / Principal Secretary, Government of Madhya Pradesh Public Health Engineering Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 7

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary / Principal Secretary, Government of Madhya Pradesh, Housing and Urban Development Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 8

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary / Principal Secretary, Government of Madhya Pradesh, Panchayat and Rural Development Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 9

\\r\\n	\\r\\n
\\r\\n Additional Chief Secretary/Principal Secretary, Government of Madhya Pradesh, Energy Department

\\r\\n	\\r\\n
\\r\\n Member

\\r\\n
\\r\\n
\\r\\n 10

\\r\\n	\\r\\n
\\r\\n Director General, MP Work Quality Council

\\r\\n	\\r\\n
\\r\\n member secretary

\\r\\n
\\r\\n
\\r\\n	 

',
                'pre_url' => 'page/content/',
                'slug' => 'executive-body',
                'added_date' => '2023-05-30 01:49:49',
                'added_by' => '1',
                'edit_date' => '2023-08-07 04:35:59',
                'edit_by' => '2',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
            [
                'id' => 19,
                'title_hi' => 'डब्ल्यूक्यूसी इतिहास 2',
                'description_hi' => '
\\r\\n	NKGNKJGNAEGND,GNDA,GNDSA,N

',
                'title_en' => 'WQC HISTORY 2',
                'description_en' => '
\\r\\n	SJBKJGNESLKGNKENG/LKSNLKFHNDLKN

',
                'pre_url' => 'page/content/',
                'slug' => 'wqc-history2',
                'added_date' => '2023-07-06 02:03:33',
                'added_by' => '1',
                'edit_date' => NULL,
                'edit_by' => '0',
                'meta_title' => NULL,
                'meta_keyword' => NULL,
                'meta_description' => NULL,
                'is_default' => 0,
                'is_on_homepage' => 0,
                'banner' => NULL,
                'is_sidebar' => 1,
                'sidebar_id' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-10-11 14:45:00',
                'updated_at' => '2023-10-11 14:45:00'
            ],
        ];
        foreach ($details as $key => $detail) {
            Page::insert($detail);
        }
    }
}
