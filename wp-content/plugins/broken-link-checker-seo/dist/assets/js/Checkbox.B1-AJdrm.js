import{d as G}from"./debounce.DK1RwK91.js";import{o as p,c as T,B as b,t as c,H as r,a as h,J as o,X as V,Y as L,F as E,D as A,C as g,a8 as f,E as m,Z as P,v as y,G as S,r as O,I as w}from"./index.9_UWDUyH.js";import{S as K}from"./Caret.BLqjRAPo.js";import{S as z}from"./Close.CP9mbBVR.js";import{_ as D}from"./dynamic-import-helper.DN_NaYa5.js";const R={},J={viewBox:"0 0 14 11",fill:"none",xmlns:"http://www.w3.org/2000/svg",class:"aioseo-checkmark"},j=b("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M10.8542 1.37147C11.44 0.785682 12.3897 0.785682 12.9755 1.37147C13.5613 1.95726 13.5613 2.907 12.9755 3.49279L6.04448 10.4238C5.74864 10.7196 5.35996 10.8661 4.97222 10.8631C4.58548 10.8653 4.19805 10.7189 3.90298 10.4238L1.0243 7.5451C0.438514 6.95931 0.438514 6.00956 1.0243 5.42378C1.61009 4.83799 2.55983 4.83799 3.14562 5.42378L4.97374 7.2519L10.8542 1.37147Z",fill:"currentColor"},null,-1),I=[j];function q(e,t){return p(),T("svg",J,I)}const U=D(R,[["render",q]]),ke={methods:{getJsonValue(e,t=null){try{e=JSON.parse(e)}catch{e=t}return e},setJsonValue(e){return JSON.stringify(e)},getJsonValues(e){return e.map(t=>JSON.parse(t))},setJsonValues(e){return e.map(t=>JSON.stringify(t))}}};function B(e){return e===0?!1:Array.isArray(e)&&e.length===0?!0:!e}function _(e){return(...t)=>!e(...t)}function Z(e,t){return e===void 0&&(e="undefined"),e===null&&(e="null"),e===!1&&(e="false"),e.toString().toLowerCase().indexOf(t.trim())!==-1}function H(e,t,s,l){return t?e.filter(a=>Z(l(a,s),t)).sort((a,n)=>l(a,s).length-l(n,s).length):e}function X(e){return e.filter(t=>!t.$isLabel)}function C(e,t){return s=>s.reduce((l,a)=>a[e]&&a[e].length?(l.push({$groupLabel:a[t],$isLabel:!0}),l.concat(a[e])):l,[])}function Y(e,t,s,l,a){return n=>n.map(i=>{if(!i[s])return console.warn("Options passed to vue-multiselect do not contain groups, despite the config."),[];const u=H(i[s],e,t,a);return u.length?{[l]:i[l],[s]:u}:[]})}const M=(...e)=>t=>e.reduce((s,l)=>l(s),t);var Q={data(){return{search:"",isOpen:!1,preferredOpenDirection:"below",optimizedHeight:this.maxHeight}},props:{internalSearch:{type:Boolean,default:!0},options:{type:Array,required:!0},multiple:{type:Boolean,default:!1},trackBy:{type:String},label:{type:String},searchable:{type:Boolean,default:!0},clearOnSelect:{type:Boolean,default:!0},hideSelected:{type:Boolean,default:!1},placeholder:{type:String,default:"Select option"},allowEmpty:{type:Boolean,default:!0},resetAfter:{type:Boolean,default:!1},closeOnSelect:{type:Boolean,default:!0},customLabel:{type:Function,default(e,t){return B(e)?"":t?e[t]:e}},taggable:{type:Boolean,default:!1},tagPlaceholder:{type:String,default:"Press enter to create a tag"},tagPosition:{type:String,default:"top"},max:{type:[Number,Boolean],default:!1},id:{default:null},optionsLimit:{type:Number,default:1e3},groupValues:{type:String},groupLabel:{type:String},groupSelect:{type:Boolean,default:!1},blockKeys:{type:Array,default(){return[]}},preserveSearch:{type:Boolean,default:!1},preselectFirst:{type:Boolean,default:!1},preventAutofocus:{type:Boolean,default:!1}},mounted(){!this.multiple&&this.max&&console.warn("[Vue-Multiselect warn]: Max prop should not be used when prop Multiple equals false."),this.preselectFirst&&!this.internalValue.length&&this.options.length&&this.select(this.filteredOptions[0])},computed:{internalValue(){return this.modelValue||this.modelValue===0?Array.isArray(this.modelValue)?this.modelValue:[this.modelValue]:[]},filteredOptions(){const e=this.search||"",t=e.toLowerCase().trim();let s=this.options.concat();return this.internalSearch?s=this.groupValues?this.filterAndFlat(s,t,this.label):H(s,t,this.label,this.customLabel):s=this.groupValues?C(this.groupValues,this.groupLabel)(s):s,s=this.hideSelected?s.filter(_(this.isSelected)):s,this.taggable&&t.length&&!this.isExistingOption(t)&&(this.tagPosition==="bottom"?s.push({isTag:!0,label:e}):s.unshift({isTag:!0,label:e})),s.slice(0,this.optionsLimit)},valueKeys(){return this.trackBy?this.internalValue.map(e=>e[this.trackBy]):this.internalValue},optionKeys(){return(this.groupValues?this.flatAndStrip(this.options):this.options).map(t=>this.customLabel(t,this.label).toString().toLowerCase())},currentOptionLabel(){return this.multiple?this.searchable?"":this.placeholder:this.internalValue.length?this.getOptionLabel(this.internalValue[0]):this.searchable?"":this.placeholder}},watch:{internalValue:{handler(){this.resetAfter&&this.internalValue.length&&(this.search="",this.$emit("update:modelValue",this.multiple?[]:null))},deep:!0},search(){this.$emit("search-change",this.search)}},emits:["open","search-change","close","select","update:modelValue","remove","tag"],methods:{getValue(){return this.multiple?this.internalValue:this.internalValue.length===0?null:this.internalValue[0]},filterAndFlat(e,t,s){return M(Y(t,s,this.groupValues,this.groupLabel,this.customLabel),C(this.groupValues,this.groupLabel))(e)},flatAndStrip(e){return M(C(this.groupValues,this.groupLabel),X)(e)},updateSearch(e){this.search=e},isExistingOption(e){return this.options?this.optionKeys.indexOf(e)>-1:!1},isSelected(e){const t=this.trackBy?e[this.trackBy]:e;return this.valueKeys.indexOf(t)>-1},isOptionDisabled(e){return!!e.$isDisabled},getOptionLabel(e){if(B(e))return"";if(e.isTag)return e.label;if(e.$isLabel)return e.$groupLabel;const t=this.customLabel(e,this.label);return B(t)?"":t},select(e,t){if(e.$isLabel&&this.groupSelect){this.selectGroup(e);return}if(!(this.blockKeys.indexOf(t)!==-1||this.disabled||e.$isDisabled||e.$isLabel)&&!(this.max&&this.multiple&&this.internalValue.length===this.max)&&!(t==="Tab"&&!this.pointerDirty)){if(e.isTag)this.$emit("tag",e.label,this.id),this.search="",this.closeOnSelect&&!this.multiple&&this.deactivate();else{if(this.isSelected(e)){t!=="Tab"&&this.removeElement(e);return}this.multiple?this.$emit("update:modelValue",this.internalValue.concat([e])):this.$emit("update:modelValue",e),this.$emit("select",e,this.id),this.clearOnSelect&&(this.search="")}this.closeOnSelect&&this.deactivate()}},selectGroup(e){const t=this.options.find(s=>s[this.groupLabel]===e.$groupLabel);if(t){if(this.wholeGroupSelected(t)){this.$emit("remove",t[this.groupValues],this.id);const s=this.trackBy?t[this.groupValues].map(a=>a[this.trackBy]):t[this.groupValues],l=this.internalValue.filter(a=>s.indexOf(this.trackBy?a[this.trackBy]:a)===-1);this.$emit("update:modelValue",l)}else{let s=t[this.groupValues].filter(l=>!(this.isOptionDisabled(l)||this.isSelected(l)));this.max&&s.splice(this.max-this.internalValue.length),this.$emit("select",s,this.id),this.$emit("update:modelValue",this.internalValue.concat(s))}this.closeOnSelect&&this.deactivate()}},wholeGroupSelected(e){return e[this.groupValues].every(t=>this.isSelected(t)||this.isOptionDisabled(t))},wholeGroupDisabled(e){return e[this.groupValues].every(this.isOptionDisabled)},removeElement(e,t=!0){if(this.disabled||e.$isDisabled)return;if(!this.allowEmpty&&this.internalValue.length<=1){this.deactivate();return}const s=typeof e=="object"?this.valueKeys.indexOf(e[this.trackBy]):this.valueKeys.indexOf(e);if(this.multiple){const l=this.internalValue.slice(0,s).concat(this.internalValue.slice(s+1));this.$emit("update:modelValue",l)}else this.$emit("update:modelValue",null);this.$emit("remove",e,this.id),this.closeOnSelect&&t&&this.deactivate()},removeLastElement(){this.blockKeys.indexOf("Delete")===-1&&this.search.length===0&&Array.isArray(this.internalValue)&&this.internalValue.length&&this.removeElement(this.internalValue[this.internalValue.length-1],!1)},activate(){this.isOpen||this.disabled||(this.adjustPosition(),this.groupValues&&this.pointer===0&&this.filteredOptions.length&&(this.pointer=1),this.isOpen=!0,this.searchable?(this.preserveSearch||(this.search=""),this.preventAutofocus||this.$nextTick(()=>this.$refs.search&&this.$refs.search.focus())):this.preventAutofocus||typeof this.$el<"u"&&this.$el.focus(),this.$emit("open",this.id))},deactivate(){this.isOpen&&(this.isOpen=!1,this.searchable?this.$refs.search!==null&&typeof this.$refs.search<"u"&&this.$refs.search.blur():typeof this.$el<"u"&&this.$el.blur(),this.preserveSearch||(this.search=""),this.$emit("close",this.getValue(),this.id))},toggle(){this.isOpen?this.deactivate():this.activate()},adjustPosition(){if(typeof window>"u")return;const e=this.$el.getBoundingClientRect().top,t=window.innerHeight-this.$el.getBoundingClientRect().bottom;t>this.maxHeight||t>e||this.openDirection==="below"||this.openDirection==="bottom"?(this.preferredOpenDirection="below",this.optimizedHeight=Math.min(t-40,this.maxHeight)):(this.preferredOpenDirection="above",this.optimizedHeight=Math.min(e-40,this.maxHeight))}}},W={data(){return{pointer:0,pointerDirty:!1}},props:{showPointer:{type:Boolean,default:!0},optionHeight:{type:Number,default:40}},computed:{pointerPosition(){return this.pointer*this.optionHeight},visibleElements(){return this.optimizedHeight/this.optionHeight}},watch:{filteredOptions(){this.pointerAdjust()},isOpen(){this.pointerDirty=!1},pointer(){this.$refs.search&&this.$refs.search.setAttribute("aria-activedescendant",this.id+"-"+this.pointer.toString())}},methods:{optionHighlight(e,t){return{"multiselect__option--highlight":e===this.pointer&&this.showPointer,"multiselect__option--selected":this.isSelected(t)}},groupHighlight(e,t){if(!this.groupSelect)return["multiselect__option--disabled",{"multiselect__option--group":t.$isLabel}];const s=this.options.find(l=>l[this.groupLabel]===t.$groupLabel);return s&&!this.wholeGroupDisabled(s)?["multiselect__option--group",{"multiselect__option--highlight":e===this.pointer&&this.showPointer},{"multiselect__option--group-selected":this.wholeGroupSelected(s)}]:"multiselect__option--disabled"},addPointerElement({key:e}="Enter"){this.filteredOptions.length>0&&this.select(this.filteredOptions[this.pointer],e),this.pointerReset()},pointerForward(){this.pointer<this.filteredOptions.length-1&&(this.pointer++,this.$refs.list.scrollTop<=this.pointerPosition-(this.visibleElements-1)*this.optionHeight&&(this.$refs.list.scrollTop=this.pointerPosition-(this.visibleElements-1)*this.optionHeight),this.filteredOptions[this.pointer]&&this.filteredOptions[this.pointer].$isLabel&&!this.groupSelect&&this.pointerForward()),this.pointerDirty=!0},pointerBackward(){this.pointer>0?(this.pointer--,this.$refs.list.scrollTop>=this.pointerPosition&&(this.$refs.list.scrollTop=this.pointerPosition),this.filteredOptions[this.pointer]&&this.filteredOptions[this.pointer].$isLabel&&!this.groupSelect&&this.pointerBackward()):this.filteredOptions[this.pointer]&&this.filteredOptions[0].$isLabel&&!this.groupSelect&&this.pointerForward(),this.pointerDirty=!0},pointerReset(){this.closeOnSelect&&(this.pointer=0,this.$refs.list&&(this.$refs.list.scrollTop=0))},pointerAdjust(){this.pointer>=this.filteredOptions.length-1&&(this.pointer=this.filteredOptions.length?this.filteredOptions.length-1:0),this.filteredOptions.length>0&&this.filteredOptions[this.pointer].$isLabel&&!this.groupSelect&&this.pointerForward()},pointerSet(e){this.pointer=e,this.pointerDirty=!0}}},F={name:"vue-multiselect",mixins:[Q,W],compatConfig:{MODE:3,ATTR_ENUMERATED_COERCION:!1},props:{name:{type:String,default:""},modelValue:{type:null,default(){return[]}},selectLabel:{type:String,default:"Press enter to select"},selectGroupLabel:{type:String,default:"Press enter to select group"},selectedLabel:{type:String,default:"Selected"},deselectLabel:{type:String,default:"Press enter to remove"},deselectGroupLabel:{type:String,default:"Press enter to deselect group"},showLabels:{type:Boolean,default:!0},limit:{type:Number,default:99999},maxHeight:{type:Number,default:300},limitText:{type:Function,default:e=>`and ${e} more`},loading:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},openDirection:{type:String,default:""},showNoOptions:{type:Boolean,default:!0},showNoResults:{type:Boolean,default:!0},tabindex:{type:Number,default:0}},computed:{hasOptionGroup(){return this.groupValues&&this.groupLabel&&this.groupSelect},isSingleLabelVisible(){return(this.singleValue||this.singleValue===0)&&(!this.isOpen||!this.searchable)&&!this.visibleValues.length},isPlaceholderVisible(){return!this.internalValue.length&&(!this.searchable||!this.isOpen)},visibleValues(){return this.multiple?this.internalValue.slice(0,this.limit):[]},singleValue(){return this.internalValue[0]},deselectLabelText(){return this.showLabels?this.deselectLabel:""},deselectGroupLabelText(){return this.showLabels?this.deselectGroupLabel:""},selectLabelText(){return this.showLabels?this.selectLabel:""},selectGroupLabelText(){return this.showLabels?this.selectGroupLabel:""},selectedLabelText(){return this.showLabels?this.selectedLabel:""},inputStyle(){return this.searchable||this.multiple&&this.modelValue&&this.modelValue.length?this.isOpen?{width:"100%"}:{width:"0",position:"absolute",padding:"0"}:""},contentStyle(){return this.options.length?{display:"inline-block"}:{display:"block"}},isAbove(){return this.openDirection==="above"||this.openDirection==="top"?!0:this.openDirection==="below"||this.openDirection==="bottom"?!1:this.preferredOpenDirection==="above"},showSearchInput(){return this.searchable&&(this.hasSingleSelectedSlot&&(this.visibleSingleValue||this.visibleSingleValue===0)?this.isOpen:!0)}}};const x={ref:"tags",class:"multiselect__tags"},ee={class:"multiselect__tags-wrap"},te={class:"multiselect__spinner"},se={key:0},ie={class:"multiselect__option"},le={class:"multiselect__option"},ne=S("No elements found. Consider changing the search query."),ae={class:"multiselect__option"},re=S("List is empty.");function oe(e,t,s,l,a,n){return p(),c("div",{tabindex:e.searchable?-1:s.tabindex,class:[{"multiselect--active":e.isOpen,"multiselect--disabled":s.disabled,"multiselect--above":n.isAbove,"multiselect--has-options-group":n.hasOptionGroup},"multiselect"],onFocus:t[14]||(t[14]=i=>e.activate()),onBlur:t[15]||(t[15]=i=>e.searchable?!1:e.deactivate()),onKeydown:[t[16]||(t[16]=f(o(i=>e.pointerForward(),["self","prevent"]),["down"])),t[17]||(t[17]=f(o(i=>e.pointerBackward(),["self","prevent"]),["up"]))],onKeypress:t[18]||(t[18]=f(o(i=>e.addPointerElement(i),["stop","self"]),["enter","tab"])),onKeyup:t[19]||(t[19]=f(i=>e.deactivate(),["esc"])),role:"combobox","aria-owns":"listbox-"+e.id},[r(e.$slots,"caret",{toggle:e.toggle},()=>[h("div",{onMousedown:t[1]||(t[1]=o(i=>e.toggle(),["prevent","stop"])),class:"multiselect__select"},null,32)]),r(e.$slots,"clear",{search:e.search}),h("div",x,[r(e.$slots,"selection",{search:e.search,remove:e.removeElement,values:n.visibleValues,isOpen:e.isOpen},()=>[V(h("div",ee,[(p(!0),c(E,null,A(n.visibleValues,(i,u)=>r(e.$slots,"tag",{option:i,search:e.search,remove:e.removeElement},()=>[(p(),c("span",{class:"multiselect__tag",key:u},[h("span",{textContent:g(e.getOptionLabel(i))},null,8,["textContent"]),h("i",{tabindex:"1",onKeypress:f(o(v=>e.removeElement(i),["prevent"]),["enter"]),onMousedown:o(v=>e.removeElement(i),["prevent"]),class:"multiselect__tag-icon"},null,40,["onKeypress","onMousedown"])]))])),256))],512),[[L,n.visibleValues.length>0]]),e.internalValue&&e.internalValue.length>s.limit?r(e.$slots,"limit",{key:0},()=>[h("strong",{class:"multiselect__strong",textContent:g(s.limitText(e.internalValue.length-s.limit))},null,8,["textContent"])]):m("v-if",!0)]),h(P,{name:"multiselect__loading"},{default:y(()=>[r(e.$slots,"loading",{},()=>[V(h("div",te,null,512),[[L,s.loading]])])]),_:3}),e.searchable?(p(),c("input",{key:0,ref:"search",name:s.name,id:e.id,type:"text",autocomplete:"off",spellcheck:!1,placeholder:e.placeholder,style:n.inputStyle,value:e.search,disabled:s.disabled,tabindex:s.tabindex,onInput:t[2]||(t[2]=i=>e.updateSearch(i.target.value)),onFocus:t[3]||(t[3]=o(i=>e.activate(),["prevent"])),onBlur:t[4]||(t[4]=o(i=>e.deactivate(),["prevent"])),onKeyup:t[5]||(t[5]=f(i=>e.deactivate(),["esc"])),onKeydown:[t[6]||(t[6]=f(o(i=>e.pointerForward(),["prevent"]),["down"])),t[7]||(t[7]=f(o(i=>e.pointerBackward(),["prevent"]),["up"])),t[9]||(t[9]=f(o(i=>e.removeLastElement(),["stop"]),["delete"]))],onKeypress:t[8]||(t[8]=f(o(i=>e.addPointerElement(i),["prevent","stop","self"]),["enter"])),class:"multiselect__input","aria-controls":"listbox-"+e.id},null,44,["name","id","placeholder","value","disabled","tabindex","aria-controls"])):m("v-if",!0),n.isSingleLabelVisible?(p(),c("span",{key:1,class:"multiselect__single",onMousedown:t[10]||(t[10]=o((...i)=>e.toggle&&e.toggle(...i),["prevent"]))},[r(e.$slots,"singleLabel",{option:n.singleValue},()=>[S(g(e.currentOptionLabel),1)])],32)):m("v-if",!0),n.isPlaceholderVisible?(p(),c("span",{key:2,class:"multiselect__placeholder",onMousedown:t[11]||(t[11]=o((...i)=>e.toggle&&e.toggle(...i),["prevent"]))},[r(e.$slots,"placeholder",{},()=>[S(g(e.placeholder),1)])],32)):m("v-if",!0)],512),h(P,{name:"multiselect"},{default:y(()=>[V(h("div",{class:"multiselect__content-wrapper",onFocus:t[12]||(t[12]=(...i)=>e.activate&&e.activate(...i)),tabindex:"-1",onMousedown:t[13]||(t[13]=o(()=>{},["prevent"])),style:{maxHeight:e.optimizedHeight+"px"},ref:"list"},[h("ul",{class:"multiselect__content",style:n.contentStyle,role:"listbox",id:"listbox-"+e.id},[r(e.$slots,"beforeList"),e.multiple&&e.max===e.internalValue.length?(p(),c("li",se,[h("span",ie,[r(e.$slots,"maxElements",{},()=>[S("Maximum of "+g(e.max)+" options selected. First remove a selected option to select another.",1)])])])):m("v-if",!0),!e.max||e.internalValue.length<e.max?(p(!0),c(E,{key:1},A(e.filteredOptions,(i,u)=>(p(),c("li",{class:"multiselect__element",key:u,id:e.id+"-"+u,role:i&&(i.$isLabel||i.$isDisabled)?null:"option"},[i&&(i.$isLabel||i.$isDisabled)?m("v-if",!0):(p(),c("span",{key:0,class:[e.optionHighlight(u,i),"multiselect__option"],onClick:o(v=>e.select(i),["stop"]),onMouseenter:o(v=>e.pointerSet(u),["self"]),"data-select":i&&i.isTag?e.tagPlaceholder:n.selectLabelText,"data-selected":n.selectedLabelText,"data-deselect":n.deselectLabelText},[r(e.$slots,"option",{option:i,search:e.search,index:u},()=>[h("span",null,g(e.getOptionLabel(i)),1)])],42,["onClick","onMouseenter","data-select","data-selected","data-deselect"])),i&&(i.$isLabel||i.$isDisabled)?(p(),c("span",{key:1,"data-select":e.groupSelect&&n.selectGroupLabelText,"data-deselect":e.groupSelect&&n.deselectGroupLabelText,class:[e.groupHighlight(u,i),"multiselect__option"],onMouseenter:o(v=>e.groupSelect&&e.pointerSet(u),["self"]),onMousedown:o(v=>e.selectGroup(i),["prevent"])},[r(e.$slots,"option",{option:i,search:e.search,index:u},()=>[h("span",null,g(e.getOptionLabel(i)),1)])],42,["data-select","data-deselect","onMouseenter","onMousedown"])):m("v-if",!0)],8,["id","role"]))),128)):m("v-if",!0),V(h("li",null,[h("span",le,[r(e.$slots,"noResult",{search:e.search},()=>[ne])])],512),[[L,s.showNoResults&&e.filteredOptions.length===0&&e.search&&!s.loading]]),V(h("li",null,[h("span",ae,[r(e.$slots,"noOptions",{},()=>[re])])],512),[[L,s.showNoOptions&&(e.options.length===0||n.hasOptionGroup===!0&&e.filteredOptions.length===0)&&!e.search&&!s.loading]]),r(e.$slots,"afterList")],12,["id"])],36),[[L,e.isOpen]])]),_:3})],42,["tabindex","aria-owns"])}F.render=oe;const ue={emits:["open","close","update:modelValue"],components:{Multiselect:F,SvgCaret:K,SvgClose:z},props:{options:{type:Array,required:!0},trackBy:{type:String,default(){return"value"}},multiple:Boolean,taggable:Boolean,filterable:Boolean,placeholder:{type:String,default(){return""}},customLabel:{type:Function,default:({label:e})=>e},name:String,modelValue:[String,Array,Number,Object],ajaxSearch:Function,noDataText:String,popperClass:String,loading:Boolean,disabled:Boolean,size:String,openDirection:{type:String,default(){return null}},groupValues:String,groupLabel:String,closeOnSelect:{type:Boolean,default(){return!0}},tagPlaceholder:String,allowEmpty:{type:Boolean,default(){return!1}}},data(){return{isLoading:!1,strings:{searchPlaceholder:this.$t.__("Type to search...",this.$td)}}},watch:{options(){this.resetFirstLastOption()}},methods:{addTag(e){e.split(",").forEach(t=>{const s={label:t,value:t};this.options.push(s),this.modelValue.push(s)}),this.$emit("update:modelValue",this.modelValue),this.$refs["aioseo-select"].$el.focus()},searchChange(e){e&&this.ajaxSearch&&(this.isLoading=!0,G(()=>{this.ajaxSearch(e).then(()=>this.isLoading=!1)},500))},resetFirstLastOption(){this.$nextTick(()=>{var t,s;if(!this.$refs["aioseo-select"])return;const e=((s=(t=this.$refs["aioseo-select"])==null?void 0:t.$el)==null?void 0:s.querySelectorAll("li.multiselect__element"))||[];e.forEach((l,a)=>{l.classList.remove("last"),l.classList.remove("first"),a===0&&l.classList.add("first"),a===e.length-1&&l.classList.add("last")})})}},mounted(){this.resetFirstLastOption()}},he={class:"multiselect__tag"},de={class:"multiselect__tag-value"},pe=["onClick"],ce=["innerHTML"],fe={class:"multiselect__select"};function ge(e,t,s,l,a,n){const i=O("svg-close"),u=O("svg-caret"),v=O("multiselect");return p(),c(v,{class:w(["aioseo-select",[{[s.size]:s.size},{multiple:s.multiple}]]),modelValue:s.modelValue,"onUpdate:modelValue":t[0]||(t[0]=d=>e.$emit("update:modelValue",d)),options:s.options,multiple:s.multiple,taggable:s.taggable,placeholder:s.placeholder||a.strings.searchPlaceholder,"tag-placeholder":s.tagPlaceholder,"show-labels":!1,"track-by":s.trackBy,"custom-label":s.customLabel,"allow-empty":s.allowEmpty||!!s.multiple,filterable:s.filterable,"internal-search":!0,loading:a.isLoading,searchable:!0,"open-direction":s.openDirection,"group-values":s.groupValues,"group-label":s.groupLabel,disabled:s.disabled,"close-on-select":s.closeOnSelect,onSearchChange:n.searchChange,onTag:n.addTag,onOpen:t[1]||(t[1]=d=>e.$emit("open")),onClose:t[2]||(t[2]=d=>e.$emit("close")),ref:"aioseo-select"},{singleLabel:y(({option:d})=>[r(e.$slots,"singleLabel",{option:d},()=>[S(g(d.label),1)])]),tag:y(({option:d,search:$,remove:k})=>[r(e.$slots,"tag",{option:d,search:$,remove:k},()=>[b("div",he,[b("div",de,g(d.label),1),b("div",{class:"multiselect__tag-remove",onClick:o(N=>k(d),["stop"])},[h(i,{onClick:o(N=>k(d),["stop"])},null,8,["onClick"])],8,pe)])])]),option:y(({option:d,search:$})=>[r(e.$slots,"option",{option:d,search:$},()=>[S(g(d.$isLabel?d.$groupLabel:d.label)+" ",1),d.docLink?(p(),T("span",{key:0,class:"docLink",innerHTML:d.docLink},null,8,ce)):m("",!0)])]),caret:y(({toggle:d})=>[r(e.$slots,"caret",{toggle:d},()=>[b("div",fe,[h(u)])])]),noOptions:y(()=>[r(e.$slots,"noOptions")]),noResult:y(()=>[r(e.$slots,"noResult")]),_:3},8,["class","modelValue","options","multiple","taggable","placeholder","tag-placeholder","track-by","custom-label","allow-empty","filterable","loading","open-direction","group-values","group-label","disabled","close-on-select","onSearchChange","onTag"])}const Be=D(ue,[["render",ge]]),me={components:{SvgCheckmark:U},props:{modelValue:Boolean,name:String,labelClass:{type:String,default(){return""}},inputClass:{type:String,default(){return""}},id:String,size:String,disabled:Boolean,round:Boolean,type:{type:String,default(){return"blue"}}},methods:{labelToggle(){this.$refs.input.click()}}},be={class:"form-checkbox-wrapper"},ye={class:"form-checkbox"},ve=["checked","name","id","disabled"];function Se(e,t,s,l,a,n){const i=O("svg-checkmark");return p(),T("label",{class:w(["aioseo-checkbox",[s.labelClass,{[s.size]:s.size},{disabled:s.disabled},{round:s.round}]]),onKeydown:[t[1]||(t[1]=f((...u)=>n.labelToggle&&n.labelToggle(...u),["enter"])),t[2]||(t[2]=f((...u)=>n.labelToggle&&n.labelToggle(...u),["space"]))],onClick:o(()=>{},["stop"])},[r(e.$slots,"header"),b("span",be,[b("span",ye,[b("input",{type:"checkbox",onInput:t[0]||(t[0]=u=>e.$emit("update:modelValue",u.target.checked)),checked:s.modelValue,name:s.name,id:s.id,class:w(s.inputClass),disabled:s.disabled,ref:"input"},null,42,ve),b("span",{class:w(["fancy-checkbox",s.type])},[h(i)],2)])]),r(e.$slots,"default")],34)}const Ce=D(me,[["render",Se]]);export{Ce as B,ke as J,U as S,Be as a};
