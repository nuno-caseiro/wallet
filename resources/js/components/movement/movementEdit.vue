<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>
            <div class="jumbotron">
                <h2>Movement</h2>

                <div class="form-group">
                    <label for="movementType">Movement type</label>
                    <select class="form-control" id="movementType" name="movementType" v-model="movement.type" @change="getCategories()"  >
                        <option></option>
                        <option v-if="isOperator"  value="i">Income</option>
                        <option v-if="isUser" value="e">Expense</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" v-model="movement.description" >
                </div>

                <div v-if="movement.transfer===true" class="form-group">
                    <label for="descriptionSource">Description</label>
                    <input type="text" class="form-control" id="descriptionSource" name="descriptionSource" v-model="movement.source_description" >
                </div>

                <div class="form-group">
                    <a class="btn btn-success" @click.prevent="saveMovement()">Save</a>
                </div>

            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	module.exports={
		props: ['movement'],
    }
</script>