import { nodeOps } from "./nodeOps";

export function toggleDisplayPass() {

  const $inputPass = nodeOps.qs('#Input-pass');
  const $checkBox = nodeOps.qs('#checkbox-pass');

  nodeOps.on($checkBox, 'change', () => {
    if ($checkBox.checked) {
      nodeOps.setAttr($inputPass, 'type', 'text');
      nodeOps.cltr($checkBox, 'bg-white');
    } else {
      nodeOps.setAttr($inputPass, 'type', 'password');
      nodeOps.clta($checkBox, 'bg-white');
    }
  })
}