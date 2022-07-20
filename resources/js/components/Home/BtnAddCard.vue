

<template>
    <v-sheet
        v-click-outside="colapseForm"
        class="btn-add-card text-center"
        :id="'btn-add-card_'+lane_id"
    >
        <p @click="expandForm" class="py-2"><v-icon class="mb-1">mdi-plus</v-icon> Adicionar um Cartão</p>
        <div class="add-card-form">
            <div class="row px-3">
                <input
                    @keyup.enter="submitForm"
                    type="text" v-model="form.title"
                    placeholder="*Título do Cartão*"
                    class="form-control mt-2"
                >
            </div>
            <div class="row">
                <div class="col-md-4">
                    <v-btn
                        color="primary"
                        elevation="6"
                        text @click="submitForm"
                    >Criar</v-btn>
                </div>
                <div class="col-md-8 text-start">
                    <v-btn
                        plain
                        color="gray"
                        icon
                        @click="colapseForm"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </div>
            </div>
        </div>
    </v-sheet>
</template>
<script>
export default {

    name: "BtnAddCard",

    props: {
        snackTrigger: Function,
        createRoute: String,
        lane_id: Number,
        user_id: Number,
        cards: Array,
    },

    data() {
        return {
            addCardFormExpanded : false,
            form: {
                title: '',
            }
        }
    },

    methods: {

        expandForm() {
            if(!this.addCardFormExpanded){

                // console.log('im expanding');
                let el = document.getElementById('btn-add-card_'+this.lane_id)
                el.classList.add('expanded')
                el.children[1].children[0].children[0].focus()
                this.addCardFormExpanded = true
            }
        },

        colapseForm() {
            // console.log(this.addCardFormExpanded)
            if(this.addCardFormExpanded){

                // console.log('im gonna colapse');
                let el = document.getElementById('btn-add-card_'+this.lane_id)
                el.classList.remove('expanded')
                this.form.title = ''
                this.addCardFormExpanded = false
            }
        },

        submitForm() {
            if(this.form.title.length){

                // console.log(this.form.title.length)
                axios.post(this.createRoute, {
                    title: this.form.title,
                    lane_id: this.lane_id,
                    author_id: this.user_id,
                }).then((response) => {

                    this.snackTrigger(true, response.data.message)

                    this.cards.push(response.data.card)
                }).catch((error) => {
                    console.log(error);
                })
                this.colapseForm()
            }else
                alert('O Título não pode ser vazio.')
        },
    }
}
</script>
<style scoped>

.btn-add-card {
    color: #56595a;
    background: #ffffff3f;
    min-width: 17rem;
    height: 2.5rem ;
    padding: 0 0.6rem;
    margin-top: 0.8rem ;
    border-radius: 0.4rem ;
    /* box-shadow: 0.2rem 0.2rem 0.2rem 0 rgba(33, 33, 33, 0.1); */
    transition: all 0.21s cubic-bezier(0.58, 1.1, 0.95, 0.99);
}

.btn-add-card:hover {
    color: #000000;
    background: #52565728;
    cursor: pointer;
    transform: scale(102%);
    box-shadow: 0.3rem 0.3rem 1rem 0.5px rgba(66, 66, 66, 0.404);
}

.btn-add-card div.add-card-form{
    display: none ;
}

.btn-add-card.expanded {
    background: #f1f5f5;
    height: 7rem ;
    cursor: default;
    transition: all 0.21s cubic-bezier(0.58, 1.1, 0.95, 0.99);
}

.btn-add-card.expanded p{
    display: none;
}

.btn-add-card.expanded div.add-card-form{
    display: initial;
}
</style>