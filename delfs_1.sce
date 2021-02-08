a= 0
b= 1
n= 10
y=exp(a)
h= (b-a)/n
    m=input("escolher o metodo: 0- Trapezio , 1- 1/3")
    if m==0 then
        soma = 0
        resultado=0
        for i=1:n
            y(i+1)=exp(a+h*i)
        end
        soma = 2*sum(y) - y(1)- y(n)
        resultado= soma*(h/2)
        disp(resultado)
    elseif m==1 then
        soma = 0
        resultado=0
        for i=1:n
            y(i+1)=exp(a+h*i)
        end
        soma = 4*sum(y) - 3*y(1)- 3*y(n)
        resultado= soma*(h/3)
        disp(resultado)
    else
        disp("error")
    end

