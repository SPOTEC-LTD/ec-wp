import"./js/vue2.RHmKp0B5.js";import{x as e,o as m,c as p,C as a,a as k,G as r,d as f,X as _}from"./js/vue.esm-bundler.CWQFYt9y.js";import{l as h}from"./js/index.BbPnCrlb.js";import{l as L}from"./js/index.BQgiQQKQ.js";import{l as S}from"./js/index.3BJ3ZnWB.js";import{f as g,b as w,u as A,l as y}from"./js/links.C2upUfsO.js";import{e as C}from"./js/elemLoaded.COgXIo-H.js";import{a as v}from"./js/addons.BNPuHzyp.js";import{u as F}from"./js/url.CXm_MEQz.js";import{S as x}from"./js/Information.CESrgQJV.js";import{S as E}from"./js/Caret.iRBf3wcH.js";import{_ as V}from"./js/_plugin-vue_export-helper.BN1snXvA.js";import"./js/translations.Buvln_cw.js";import"./js/default-i18n.Bd0Z306Z.js";import"./js/constants.DpuIWwJ9.js";import"./js/helpers.D2xRWOvn.js";import"./js/upperFirst.CP4N4hLd.js";import"./js/_stringToArray.DnK4tKcY.js";import"./js/toString.XwB3Xa5p.js";const P={setup(){return{licenseStore:g(),postEditorStore:w(),rootStore:A()}},components:{SvgCircleInformation:x,SvgClose:E},data(){return{linkFormatValue:{},disabled:!1,url:null,strings:{upsell:this.$t.sprintf(this.$t.__("Did you know you can automatically add internal links using Link Assistant? %1$s",this.$td),this.$links.getPlainLink(this.$constants.GLOBAL_STRINGS.learnMore,this.rootStore.aioseo.urls.aio.linkAssistant,!0))}}},computed:{canShowUpsell(){const t=v.getAddon("aioseo-link-assistant"),{options:o}=this.postEditorStore.currentPost,i=o.linkFormat.internalLinkCount,n=o.linkFormat.linkAssistantDismissed;return(this.licenseStore.isUnlicensed||!t||!t.isActive||t.requiresUpgrade)&&2<i&&!n&&!this.disabled&&this.linkFormatValue.url&&this.isInternalLink(this.linkFormatValue.url)}},methods:{async linkAdded(t){var s;await this.$nextTick();const{options:o}=this.postEditorStore.currentPost,i=o.linkFormat.internalLinkCount,n=o.linkFormat.linkAssistantDismissed;2<i||n||this.isInternalLink(t.url||((s=t.suggestion)==null?void 0:s.url)||null)&&this.postEditorStore.incrementInternalLinkCount()},async setLinkFormatValue(){await this.$nextTick();const t=document.querySelector("#aioseo-link-assistant-education input");!this.linkFormatValue.url&&(t!=null&&t.value)&&(this.linkFormatValue=JSON.parse(t.value))},isInternalLink(t){const o=F.parse(t,!1,!0);return t.indexOf("//")===-1&&t.indexOf("/")===0?!0:t.indexOf("#")===0?!1:o.host?o.host===this.rootStore.aioseo.urls.domain:!0}},created(){this.setLinkFormatValue();const{addAction:t,hasAction:o}=window.wp.hooks;o("aioseo-link-format-link-added","aioseo")||t("aioseo-link-format-link-added","aioseo",this.linkAdded)}},D={key:0,class:"aioseo-link-assistant-did-you-know"},I=["innerHTML"];function N(t,o,i,n,s,u){const c=e("svg-circle-information"),d=e("svg-close");return u.canShowUpsell?(m(),p("div",D,[a(c),k("span",{onClick:o[0]||(o[0]=r($=>s.disabled=!0,["stop"])),innerHTML:s.strings.upsell},null,8,I),a(d,{onClick:r(n.postEditorStore.disableLinkAssistantEducation,["stop"])},null,8,["onClick"])])):f("",!0)}const U=V(P,[["render",N]]),l=()=>{let t=_({...U,name:"Standalone/LinkFormat"});t=h(t),t=L(t),t=S(t),y(t),t.mount("#aioseo-link-assistant-education-mount")};window.aioseo&&window.aioseo.currentPost&&window.aioseo.currentPost.context==="post"&&(document.getElementById("aioseo-link-assistant-education")?l():(C("#aioseo-link-assistant-education","aioseoLaDidYouKnow"),document.addEventListener("animationstart",function(o){o.animationName==="aioseoLaDidYouKnow"&&l()},{passive:!0})));
