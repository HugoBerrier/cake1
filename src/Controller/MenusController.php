<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Menus Controller
 *
 */
class MenusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Menus->find();
        $menus = $this->paginate($query);

        $this->set(compact('menus'));
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, contain: []);
        $this->set(compact('menu'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEmptyEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $this->set(compact('menu'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $this->set(compact('menu'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

// In src/Controller/MenusController.php, add the following method:

// In src/Controller/MenusController.php
public function addDefaultMenus()
{
    $menusTable = $this->Menus;
    $menu1 = $menusTable->newEntity(['ordre' => 1, 'intitule' => 'Utilisateurs', 'lien' => '/users/index']);
    $menu2 = $menusTable->newEntity(['ordre' => 2, 'intitule' => 'Menu', 'lien' => '/menus/index']);
    $menusTable->saveMany([$menu1, $menu2]);
    $this->Flash->success('Default menus added.');
    return $this->redirect(['action' => 'index']);
}
// In src/Controller/MenusController.php
public function reorder()
{
    $this->request->allowMethod(['post']);
    $order = $this->request->getData('order');
    $menusTable = $this->Menus;

    foreach ($order as $index => $id) {
        $menu = $menusTable->get($id);
        $menu->ordre = $index + 1;
        $menusTable->save($menu);
    }

    $this->set('response', ['status' => 'success']);
    $this->viewBuilder()->setOption('serialize', 'response');
}

}
