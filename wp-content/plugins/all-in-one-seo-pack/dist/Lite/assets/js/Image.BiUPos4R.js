import{C as g,E as m,z as h,b as u,F as w,G as E,H as P,u as f,a as p,e as v}from"./links.BdfvOpfI.js";import{g as $,a as O,b as U,c as _,d as y}from"./postSlug.CqYKoIBF.js";const x=()=>{var e;let t=0;return(g()||m())&&(t=parseInt((e=document.getElementById("post_author_override"))==null?void 0:e.value)),h()&&(t=window.wp.data.select("core/editor").getEditedPostAttribute("author")),t||(t=u().currentPost.postAuthor),t},A=()=>{const t=document.querySelector("#set-post-thumbnail img");return t?t.getAttribute("src"):""},I=async(t=!1)=>{var a;const e=window.wp.data.select("core/editor"),i=t&&e?e==null?void 0:e.getEditedPostAttribute("featured_media"):(a=e==null?void 0:e.getCurrentPost())==null?void 0:a.featured_media;return typeof i>"u"?new Promise(o=>setTimeout(()=>o(I(t)),1e3)):i},S=async()=>{if(g()||m())return A();if(h()){const t=await I(!0).then(i=>i);return isNaN(t)||t===0?"":u().getMediaData({mediaId:t}).then(i=>i.source_url)}return w()?$().featuredImage:E()?O().featuredImage:P()?U().featuredImage:""},D={emits:["updateSocialImagePreview"],data(){return{excludedTermOptions:["featured","attach","content","author","auto"],excludedAttachmentOptions:["featured","content","author"],excludedPageBuilderOptions:["auto"]}},computed:{imageSourceOptions(){return[{label:this.$t.__("Default Image (Set Below)",this.$td),value:"default"},{label:this.$t.__("Featured Image",this.$td),value:"featured"},{label:this.$t.__("Attached Image",this.$td),value:"attach"},{label:this.$t.__("First Image in Content",this.$td),value:"content"},{label:this.$t.__("Image from Custom Field",this.$td),value:"custom"},{label:this.$t.__("Post Author Image",this.$td),value:"author"},{label:this.$t.__("First Available Image",this.$td),value:"auto"}]},imageSourceOptionsFiltered(){var a,o,r;const t=u(),e=this.imageSourceOptions.map(s=>(s.value==="default"&&(s.label=this.$t.__("Default Image Source (Set in Social Networks)",this.$td)),s)).concat({label:this.$t.__("Custom Image",this.$td),value:"custom_image"});if(((a=t.currentPost)==null?void 0:a.context)==="term")return e.filter(s=>!this.excludedTermOptions.includes(s.value));if(((o=t.currentPost)==null?void 0:o.context)==="post"&&((r=t.currentPost)==null?void 0:r.postType)==="attachment")return e.filter(s=>!this.excludedAttachmentOptions.includes(s.value));const i=f();return i.aioseo.integration?((i.aioseo.integration==="seedprod"||i.aioseo.integration==="wpbakery"&&window.vc_mode==="admin_frontend_editor")&&this.excludedPageBuilderOptions.push("featured"),e.filter(s=>!this.excludedPageBuilderOptions.includes(s.value))):e}},methods:{getTermImageSourceOptions(){return this.imageSourceOptions.filter(t=>!this.excludedTermOptions.includes(t.value))},getImageSourceOption(t){return this.imageSourceOptions.find(e=>e.value===t)},getImageSourceOptionFiltered(t){return this.imageSourceOptionsFiltered.find(e=>e.value===t)}}},b=()=>{let t=null;const e=/<img.*?src=['"](.*?)['"].*?>/i.exec(y());return e&&e[1]&&(t=e[1]),t},F=async(t,e,i)=>{let a=_(t[`${i}image_custom_fields`]);return a||await S().then(o=>{a=o}),a||await u().getFirstAttachedImage({postId:t.id}).then(r=>{a=r}),a||(a=b()),a||(a=p().options.social[e].homePage.image),a},k=async()=>{let t="";const e=x();return await u().getUserImage({userId:e}).then(a=>{t=a}),t},T={data(){return{imageUrl:"",loading:!1}},methods:{async setImageUrl(t=""){var d;const e=p(),i=u(),a=v(),o=i.currentPost,r=t||((d=a.metaBoxTabs)==null?void 0:d.social)||"facebook",s=r==="facebook"||r==="twitter"&&o.twitter_use_og?"og_":"twitter_";let l=o[`${s}image_type`]||"default";switch(l==="default"&&(l=e.options.social[r].general.defaultImageSourcePosts),this.imageUrl="",l){case"featured":this.loading=!0,await S().then(n=>{this.imageUrl=n,this.loading=!1});break;case"attach":this.loading=!0,await i.getFirstAttachedImage({postId:o.id}).then(n=>{this.imageUrl=n,this.loading=!1});break;case"content":this.imageUrl=b();break;case"author":this.loading=!0,await k().then(n=>{this.imageUrl=n,this.loading=!1});break;case"auto":this.loading=!0,await F(o,r,s).then(n=>{this.imageUrl=n,this.loading=!1});break;case"custom":this.imageUrl=_(o[`${s}image_custom_fields`]);break;case"custom_image":this.imageUrl=o[`${s}image_custom_url`];break;case"default":default:this.imageUrl=e.options.social[r].general.defaultImagePosts;break}!this.imageUrl&&e.options.social[r].general.defaultImagePosts&&(this.imageUrl=e.options.social[r].general.defaultImagePosts);const c=f();!this.imageUrl&&c.aioseo.urls.siteLogo&&(this.imageUrl=c.aioseo.urls.siteLogo),window.aioseoBus.$emit("updateSocialImagePreview",{social:r,image:this.imageUrl})}}};export{D as I,T as a};
