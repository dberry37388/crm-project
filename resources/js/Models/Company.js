import Model from './Model'

export default class Company extends Model {
    // Set the resource route of the model
    resource() {
        return 'companies'
    }
}
