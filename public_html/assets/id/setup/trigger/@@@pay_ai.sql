AFTER INSERT ON `@@@pay` FOR EACH ROW
IF (NEW.`sum`<>0 AND NEW.payd=1) THEN
    CALL @@@sportsmen_calc_saldo(NEW.`sportsmen`);
    IF (NEW.`sum`>0) THEN
        CALL @@@invoicepay_newpay(NEW.`sportsmen`, NEW.`id`, NEW.`sum`);
    END IF;
END IF