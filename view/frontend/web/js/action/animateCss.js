define([
], function (
) {
    return function (element, animation, prefix = 'vmpl-animate__', time = 'faster') {
      return new Promise((resolve, reject) => {
          const animationName = `${prefix}${animation}`;
          const node = element instanceof HTMLElement ? element : document.querySelector(element.toString());

          node.classList.add(`${prefix}animated`, `${prefix}${time}`, animationName);

          // When the animation ends, we clean the classes and resolve the Promise
          node.addEventListener('animationend', (event) => {
              event.stopPropagation();
              node.classList.remove(`${prefix}animated`, animationName, `${prefix}${time}`);
              resolve('Animation ended');
          }, {once: true});
      })
    }
})
