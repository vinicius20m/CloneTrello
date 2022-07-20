

<template>
    <v-sheet
        v-click-outside="colapseForm"
        class="btn-add-lane text-center"
    >

        <h5 @click="expandForm" class="py-2"><v-icon class="mb-1">mdi-plus</v-icon> Adicionar uma Lista</h5>
        <div class="add-lane-form">
            <div class="row mt-2 px-3">
                <input
                    @keyup.enter="submitForm"
                    type="text" v-model="form.title"
                    placeholder="*Título da Lista*"
                    class="form-control"
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
    name: "BtnAddLane",
    props: {
        snackTrigger: Function,
        createRoute: String,
        board_id: Number,
        user_id: Number,
        lanes: Array,
    },
    data() {
        return {
            addLaneFormExpanded : false,
            form: {
                title: '',
            }
        }
    },
    methods: {

        expandForm() {
            if(!this.addLaneFormExpanded){

                // console.log('im expanding');
                let el = document.getElementsByClassName('btn-add-lane')[0]
                el.classList.add('expanded')
                el.children[1].children[0].children[0].focus()
                this.addLaneFormExpanded = true
            }
        },

        colapseForm() {
            // console.log(this.addLaneFormExpanded)
            if(this.addLaneFormExpanded){

                // console.log('im gonna colapse');
                let el = document.getElementsByClassName('btn-add-lane')[0]
                el.classList.remove('expanded')
                this.form.title = ''
                this.addLaneFormExpanded = false
            }
        },

        submitForm() {
            if(this.form.title.length){

                // console.log(this.form.title.length)
                axios.post(this.createRoute, {
                    title: this.form.title,
                    board_id: this.board_id,
                    author_id: this.user_id,
                }).then((response) => {

                    this.snackTrigger(true, response.data.message)

                    this.lanes.push(response.data.lane)
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

.btn-add-lane {
    color: #56595a;
    background: #b0bcc049;
    min-width: 17rem;
    height: 2.5rem ;
    margin: 0 0.8rem;
    padding: 0 0.6rem;
    border-radius: 0.8rem;
    box-shadow: 0.2rem 0.2rem 0.2rem 0 rgba(33, 33, 33, 0.1);
    transition: all 0.21s cubic-bezier(0.58, 1.1, 0.95, 0.99);
}

.btn-add-lane:hover {
    color: #000000;
    background: #b0bcc09a;
    cursor: pointer;
    transform: scale(102%);
    box-shadow: 0.3rem 0.3rem 1rem 0.5px rgba(66, 66, 66, 0.404);
}

.btn-add-lane div.add-lane-form{
    display: none ;
}

.btn-add-lane.expanded {
    background: #f1f5f5;
    height: 7rem ;
    cursor: default;
    transition: all 0.21s cubic-bezier(0.58, 1.1, 0.95, 0.99);
}

.btn-add-lane.expanded h5{
    display: none;
}

.btn-add-lane.expanded div.add-lane-form{
    display: unset;
}
</style>