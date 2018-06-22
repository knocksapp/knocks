<template>
<div :class = "[{'row' : !tiny } , {'row white knocks_gray_border knocks_tinny_border_radius ' : tiny}] ">
  <knocksuser v-model = "authModel" class = "knocks_hidden" :user = 'auth'></knocksuser>
  <div class="col s12 knocks_mp_top_margin knocks_xs_padding">
    <p class = "knocks_text_ms center knocks_text_dark" v-if = "tiny">
      <span class = "knocks-suitcase3"></span>
      <static_message msg = "Add a career"></static_message>
    </p>
    <knockselselect
    allow_create
    v-model = "works_at"
    is_required
    icon = "knocks-office"
    :error_mixins = "[{ key : 'is_required' , mixin : { msg : 'You need to write where did you work.' , icon : 'knocks-alert-circle' } }]"
    :max_len = "70"
    :min_len = "2"
    general_icon = "knocks-tag-add"
    placeholder = "Works At"
    :scope = "['career_adder'+_uid]"></knockselselect>
  </div>
  <div class="col s12 knocks_mp_top_margin knocks_xs_padding">
    <knockselselect
    :feeds = '[
    { label : "Architecture and Engineering Occupations", icon : "knocks-ruler2" ,
    value : "Architecture and Engineering Occupations" } ,
    { label : "Arts, Design, Entertainment, Sports, and Media Occupations", icon : "knocks-tools2" ,
    value : "Arts, Design, Entertainment, Sports, and Media Occupations" } ,
    { label : "Building and Grounds Cleaning and Maintenance Occupations", icon : "knocks-building-o" ,
    value : "Building and Grounds Cleaning and Maintenance Occupations" } ,
    { label : "Business and Financial Operations Occupations", icon : "knocks-suitcase3" ,
    value : "Business and Financial Operations Occupations" } ,
    { label : "Community and Social Services Occupations", icon : "knocks-flower" ,
    value : "Community and Social Services Occupations" } ,
    { label : "Computer and Mathematical Occupations", icon : "knocks-monitor4" ,
    value : "Computer and Mathematical Occupations" } ,
    { label : "Construction and Extraction Occupations", icon : "knocksapp-bury"
    , value : "Construction and Extraction Occupations" } ,
    { label : "Education, Training, and Library Occupations", icon : "knocks-archive6" ,
    value : "Education, Training, and Library Occupations" } ,
    { label : "Farming, Fishing, and Forestry Occupations", icon : "knocksapp-plant" ,
    value :  "Farming, Fishing, and Forestry Occupations" } ,
    { label : "Food Preparation and Serving Related Occupations", icon : "knocksapp-blend" ,
    value :  "Food Preparation and Serving Related Occupations" } ,
    { label : "Healthcare Practitioners and Technical Occupations", icon : "knocksapp-aid2" ,
    value : "Healthcare Practitioners and Technical Occupations" } ,
    { label : "Healthcare Support Occupations", icon : "knocks-plus-circle" ,
    value : "Healthcare Support Occupations" } ,
    { label : "Installation, Maintenance, and Repair Occupations", icon : "knocks-tools-2" ,
    value : "Installation, Maintenance, and Repair Occupations" } ,
    { label : "Legal Occupations", icon : "knocks-gavel" ,
    value : "Legal Occupations" } ,
    { label : "Life, Physical, and Social Science Occupations", icon : "knocksapp-experiment" ,
    value : "Life, Physical, and Social Science Occupations" } ,
    { label : "Management Occupations", icon : "knocks-group-1" ,
    value : "Management Occupations" } ,
    { label : "Military Specific Occupations", icon : "knocksapp-fly" ,
    value : "Military Specific Occupations" } ,
    { label : "Office and Administrative Support Occupations", icon : "knocks-connection2" ,
    value : "Office and Administrative Support Occupations" } ,
    { label : "Personal Care and Service Occupations", icon : "knocks-wheelchair" ,
    value : "Personal Care and Service Occupations" } ,
    { label : "Production Occupations", icon : "knocksapp-refrigerate" ,
    value : "Production Occupations" } ,
    { label : "Protective Service Occupations", icon : "knocks-fire-extinguisher" ,
    value : "Protective Service Occupations" } ,
    { label : "Sales and Related Occupations", icon : "knocks-money" ,
    value : "Sales and Related Occupations" } ,
    ]'
    allow_create
    v-model = "works_what"
    is_required
    icon = "knocks-suitcase3"
    :error_mixins = "[{ key : 'is_required' , mixin : { msg : 'You need to write the major name.' , icon : 'knocks-alert-circle' } }]"
    :max_len = "70"
    :min_len = "2"
    general_icon = "knocks-tag-add"
    placeholder = "Major"
    :scope = "['career_adder'+_uid]"></knockselselect>
  </div>
  <div class="col s12 knocks_mp_top_margin knocks_xs_padding ">
    <knockselselect
    :feeds = '[
    "Academic librarian",
    "Accountant",
    "Accounting technician",
    "Actuary",
    "Adult nurse",
    "Advertising account executive",
    "Advertising account planner",
    "Advertising copywriter",
    "Advice worker",
    "Advocate (Scotland)",
    "Aeronautical engineer",
    "Agricultural consultant",
    "Agricultural manager",
    "Aid worker/humanitarian worker",
    "Air traffic controller",
    "Airline cabin crew",
    "Amenity horticulturist",
    "Analytical chemist",
    "Animal nutritionist",
    "Animator",
    "Archaeologist",
    "Architect",
    "Architectural technologist",
    "Archivist",
    "Armed forces officer",
    "Aromatherapist",
    "Art therapist",
    "Arts administrator",
    "Auditor",
    "Automotive engineer",
    "Barrister",
    "Barrister’s clerk",
    "Bilingual secretary",
    "Biomedical engineer",
    "Biomedical scientist",
    "Biotechnologist",
    "Brand manager",
    "Broadcasting presenter",
    "Building control officer/surveyor",
    "Building services engineer",
    "Building surveyor",
    "Camera operator",
    "Careers adviser (higher education)",
    "Careers adviser",
    "Careers consultant",
    "Cartographer",
    "Catering manager",
    "Charities administrator",
    "Charities fundraiser",
    "Chemical (process) engineer",
    "Child psychotherapist",
    "Children nurse",
    "Chiropractor",
    "Civil engineer",
    "Civil Service administrator",
    "Clinical biochemist",
    "Clinical cytogeneticist",
    "Clinical microbiologist",
    "Clinical molecular geneticist",
    "Clinical research associate",
    "Clinical scientist - tissue typing",
    "Clothing and textile technologist",
    "Colour technologist",
    "Commercial horticulturist",
    "Commercial/residential/rural surveyor",
    "Commissioning editor",
    "Commissioning engineer",
    "Commodity broker",
    "Communications engineer",
    "Community arts worker",
    "Community education officer",
    "Community worker",
    "Company secretary",
    "Computer sales support",
    "Computer scientist",
    "Conference organiser",
    "Consultant",
    "Consumer rights adviser",
    "Control and instrumentation engineer",
    "Corporate banker",
    "Corporate treasurer",
    "Counsellor",
    "Courier/tour guide",
    "Court reporter/verbatim reporter",
    "Credit analyst",
    "Crown Prosecution Service lawyer",
    "Crystallographer",
    "Curator",
    "Customs officer",
    "Cyber security specialist",
    "Dance movement therapist",
    "Data analyst",
    "Data scientist",
    "Data visualisation analyst",
    "Database administrator",
    "Debt/finance adviser",
    "Dental hygienist",
    "Dentist",
    "Design engineer",
    "Dietitian",
    "Diplomatic service",
    "Doctor (general practitioner)",
    "Doctor (hospital)",
    "Dramatherapist",
    "Economist",
    "Editorial assistant",
    "Education administrator",
    "Electrical engineer",
    "Electronics engineer",
    "Employment advice worker",
    "Energy conservation officer",
    "Engineering geologist",
    "Environmental education officer",
    "Environmental health officer",
    "Environmental manager",
    "Environmental scientist",
    "Equal opportunities officer",
    "Equality and diversity officer",
    "Ergonomist",
    "Estate agent",
    "European Commission administrators",
    "Exhibition display designer",
    "Exhibition organiser",
    "Exploration geologist",
    "Facilities manager",
    "Field trials officer",
    "Financial manager",
    "Firefighter",
    "Fisheries officer",
    "Fitness centre manager",
    "Food scientist",
    "Food technologist",
    "Forensic scientist",
    "Full stack developer",
    "Geneticist",
    "Geographical information systems manager",
    "Geomatics/land surveyor",
    "Government lawyer",
    "Government research officer",
    "Graphic designer",
    "Health and safety adviser",
    "Health and safety inspector",
    "Health promotion specialist",
    "Health service manager",
    "Health visitor",
    "Herbalist",
    "Heritage manager",
    "Higher education administrator",
    "Higher education advice worker",
    "Homeless worker",
    "Horticultural consultant",
    "Hotel manager",
    "Housing adviser",
    "Human resources officer",
    "Hydrologist",
    "Illustrator",
    "Immigration officer",
    "Immunologist",
    "Industrial/product designer",
    "Information scientist",
    "Information systems manager",
    "Information technology/software trainers",
    "Insurance broker",
    "Insurance claims inspector",
    "Insurance risk surveyor",
    "Insurance underwriter",
    "Interpreter",
    "Investment analyst",
    "Investment banker - corporate finance",
    "Investment banker – operations",
    "Investment fund manager",
    "IT consultant",
    "IT support analyst",
    "Journalist",
    "Laboratory technician",
    "Land-based engineer",
    "Landscape architect",
    "Learning disability nurse",
    "Learning mentor",
    "Lecturer (adult education)",
    "Lecturer (further education)",
    "Lecturer (higher education)",
    "Legal executive",
    "Leisure centre manager",
    "Licensed conveyancer",
    "Local government administrator",
    "Local government lawyer",
    "Logistics/distribution manager",
    "Magazine features editor",
    "Magazine journalist",
    "Maintenance engineer",
    "Management accountant",
    "Manufacturing engineer",
    "Manufacturing machine operator",
    "Manufacturing toolmaker",
    "Marine scientist",
    "Market research analyst",
    "Market research executive",
    "Marketing account manager",
    "Marketing assistant",
    "Marketing executive",
    "Marketing manager (social media)",
    "Materials engineer",
    "Materials specialist",
    "Mechanical engineer",
    "Media analyst",
    "Media buyer",
    "Media planner",
    "Medical physicist",
    "Medical representative",
    "Mental health nurse",
    "Metallurgist",
    "Meteorologist",
    "Microbiologist",
    "Midwife",
    "Mining engineer",
    "Mobile developer",
    "Multimedia programmer",
    "Multimedia specialists",
    "Museum education officer",
    "Museum/gallery exhibition officer",
    "Music therapist",
    "Nanoscientist",
    "Nature conservation officer",
    "Naval architect",
    "Network administrator",
    "Nurse",
    "Nutritional therapist",
    "Nutritionist",
    "Occupational therapist",
    "Oceanographer",
    "Office manager",
    "Operational researcher",
    "Orthoptist",
    "Outdoor pursuits manager",
    "Packaging technologist",
    "Paediatric nurse",
    "Paramedic",
    "Patent attorney",
    "Patent examiner",
    "Pension scheme manager",
    "Personal assistant",
    "Petroleum engineer",
    "Pharmacist",
    "Pharmacologist",
    "Pharmacovigilance officer",
    "Photographer",
    "Physiotherapist",
    "Picture researcher",
    "Planning and development surveyor",
    "Planning technician",
    "Plant breeder",
    "Police officer",
    "Political party agent",
    "Political party research officer",
    "Practice nurse",
    "Press photographer",
    "Press sub-editor",
    "Prison officer",
    "Private music teacher",
    "Probation officer",
    "Product development scientist",
    "Production manager",
    "Programme researcher",
    "Programmer",
    "Project manager",
    "Psychologist (clinical)",
    "Psychologist (educational)",
    "Psychotherapist",
    "Public affairs consultant (lobbyist)",
    "Public affairs consultant (research)",
    "Public house manager",
    "Public librarian",
    "Public relations (PR) officer",
    "QA analyst",
    "Quality assurance manager",
    "Quantity surveyor",
    "Records manager",
    "Recruitment consultant",
    "Recycling officer",
    "Regulatory affairs officer",
    "Research chemist",
    "Research scientist",
    "Restaurant manager",
    "Retail banker",
    "Retail buyer",
    "Retail manager",
    "Retail merchandiser",
    "Retail pharmacist",
    "Sales executive",
    "Scene of crime officer",
    "Secretary",
    "Seismic interpreter",
    "Site engineer",
    "Site manager",
    "Social researcher",
    "Social worker",
    "Software developer",
    "Soil scientist",
    "Solicitor",
    "Speech and language therapist",
    "Sports coach",
    "Sports development officer",
    "Sports therapist",
    "Statistician",
    "Stockbroker",
    "Structural engineer",
    "Systems analyst",
    "Systems developer",
    "Tax inspector",
    "Teacher (nursery/early years)",
    "Teacher (primary)",
    "Teacher (secondary)",
    "Teacher (special educational needs)",
    "Teaching/classroom assistant",
    "Technical author",
    "Technical sales engineer",
    "TEFL/TESL teacher",
    "Television production assistant",
    "Test automation developer",
    "Tour operator",
    "Tourism officer",
    "Tourist information manager",
    "Town and country planner",
    "Toxicologist",
    "Trade union research officer",
    "Trader",
    "Trading standards officer",
    "Training and development officer",
    "Translator",
    "Transportation planner",
    "Travel agent",
    "TV/film/theatre set designer",
    "UX designer",
    "Validation engineer",
    "Veterinary nurse",
    "Veterinary surgeon",
    "Video game designer",
    "Video game developer",
    "Volunteer work organiser",
    "Warehouse manager",
    "Waste disposal officer",
    "Water conservation officer",
    "Water engineer",
    "Web designer",
    "Web developer",
    "Welfare rights adviser",
    "Writer",
    "Youth worker",
    ]'
    allow_create
    v-model = "works_as"
    is_required
    icon = "knocks-black-tie"
    :error_mixins = "[{ key : 'is_required' , mixin : { msg : 'You need to write the major name.' , icon : 'knocks-alert-circle' } }]"
    :max_len = "70"
    :min_len = "2"
    general_icon = "knocks-toolbox"
    placeholder = "Works as ?"
    :scope = "['career_adder'+_uid]"></knockselselect>
  </div>
  <div class="col s12 knocks_mp_top_margin knocks_xs_padding">

    <knockseldatepicker
    v-if = "authModel != null"
    :scope = "['career_adder'+_uid]"
    icon = "knocks-calendar7"
    is_required
    :quick = "[
    {msg : 'When i was 20' , margins : { count : 20 , unit : 'y' , from : authModel.birthdate } } ,
    {msg : 'When i was 25' , margins : { count : 25 , unit : 'y' , from : authModel.birthdate } }
    ]"
    :margins = '{ max : { count : 0 , unit : "y" } , min : { from : authModel.birthdate , count : 3 , unit : "y" } }'
    placeholder = "Works Since ?"
    v-model = "works_since"></knockseldatepicker>

  </div>
  <div class="col s12 knocks_mp_top_margin knocks_xs_padding ">
    <knockseldatepicker
    v-if = "authModel != null"
    :quick = "[]"
    icon = "knocks-calendar-check-o"
    :scope = "['career_adder'+_uid]"
    :margins = '{ max : { count : 0 , unit : "y" } , min : { date : works_since } }'
    placeholder = "Works To ?"
    v-model = "works_to"></knockseldatepicker>
  </div>
  <div class="col s12 knocks_mp_top_margin knocks_xs_padding">
    <knockselbutton
    placeholder = "Add"
    type = "primary"
    class = "right"
    :error_at = []
    :scope = "['career_adder'+_uid]"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "career"
    computed_response
    success_msg = "Saved."
    gid = "stage_one_net"
    :submit_data = " {works_at : works_at , works_since : worksSince, works_to : worksTo , works_what : works_what , works_as : works_as} "
    :disabled = "!testDate"
    @knocks_submit_accepted = "passToParent($event)"
    >
    </knockselbutton>
  </div>
</div>
</div>
</template>
<script>
export default {
  name: 'knocksusercareers',
  props :{
    tiny : {
      type : Boolean ,
      default : false
    }
  },
  methods:{
        passToParent(e){
            let ob = e.submit_data ;
            ob.id = e.response;
            this.$emit('knocks_career_submited' , ob );
        }
  },
  mounted(){
  },
  data() {
      return {
        auth : parseInt(UserId) ,
        authModel : null ,
        value1: '',
        value2: '',
        works_at : '',
        works_to : null,
        works_what : '',
        works_as : '',
        works_since : null
      }
    },
    computed : {
        worksTo(){
            if(this.works_to == null) return null ;
            return moment(this.works_to).format('YYYY-MM-DD');
        },
        worksSince(){
            if(this.works_since == null) return null ;
            return moment(this.works_since).format('YYYY-MM-DD');
        },
        testDate(){
            if(this.worksSince == null) return false ;
            if(this.worksTo == null && this.worksSince != null) return true;
            if (moment(this.worksTo).diff(moment(this.worksSince)) <= 0)
                return false;
            else
                return true;
        }
    }
  }
</script>
<style lang="css" scoped>
</style>
