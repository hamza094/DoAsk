<template>
    <div>
  <input id="trix" class="body" type="hidden" :name="name" :value="value">
  <trix-editor ref="trix" input="trix"  :placeholder="placeholder"></trix-editor>
    </div>
</template>

<style lang="scss">
    @import '~tributejs/dist/tribute.css';
</style>

<script>
    import Trix from 'trix';
    import Tribute from 'tributejs';
       Vue.config.ignoredElements = ['trix-editor'];
export default{
    props:['name','value','placeholder','shouldClear'],
       data() {
            return {
                query: ''
            }
        },
       methods: {
          remoteSearch(text, callback) {
                this.query = text;
                axios.get(`/api/users?name=${text}`)
                    .then(({data}) => {
                        callback(data);
                    }).catch(() => {
                        callback([]);
                })
            }
        },
    
    mounted(){
         let el = this.$refs.trix;
            new Tribute({
                values: (text, cb) => {
                    this.remoteSearch(text, cb);
                },
                lookup: 'name',
            }).attach(el);
            el.addEventListener('tribute-replaced', (e) => {
                // set selected range
                let range = el.editor.getSelectedRange();
                el.editor.setSelectedRange([range[0] - this.query.length, range[1]]);
                // // delete typed text and insert the matched item
                el.editor.deleteInDirection("forward");
                el.editor.insertString(e.detail.item.original.name);
            });
        
        this.$refs.trix.addEventListener('trix-change',e=>{
            this.$emit('input',e.target.innerHTML);
        });
        this.$watch('shouldClear',()=>{
            this.$refs.trix.value='';
        });
    }
}
</script>
<style scoped>
    trix-editor{
        min-height: 100px;
    }
</style>